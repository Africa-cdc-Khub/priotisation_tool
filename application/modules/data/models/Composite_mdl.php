<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Composite index, probability, and priority calculations for member_state_diseases_data.
 *
 * Priority thresholds (aligned with dashboard charts):
 *   High   : probability >= 0.80
 *   Medium : 0.65 <= probability < 0.80
 *   Low    : probability < 0.65
 */
#[AllowDynamicProperties]
class Composite_mdl extends CI_Model
{
	protected $parameters = [];
	protected $beta_value = 2.718;

	public function __construct()
	{
		parent::__construct();
		$this->db->query('SET SESSION sql_mode = ""');

		$params = $this->db->get('parameters')->result();
		foreach ($params as $param) {
			$this->parameters[$param->header] = (float) $param->beta;
		}

		$beta = $this->db->where('is_current', 1)->get('beta_value')->row();
		if ($beta) {
			$this->beta_value = (float) $beta->value;
		}
	}

	/**
	 * Map probability (0–1) to priority label. Single source of truth for UI and DB.
	 */
	public function priorityFromProbability($probability)
	{
		$p = (float) $probability;
		if ($p >= 0.8) {
			return 'High';
		}
		if ($p >= 0.65) {
			return 'Medium';
		}
		return 'Low';
	}

	/**
	 * Compute all derived fields from the five criteria inputs.
	 */
	public function calculateMetrics($detect, $prev, $morbid, $case, $mort)
	{
		$detect = (float) $detect;
		$prev = (float) $prev;
		$morbid = (float) $morbid;
		$case = (float) $case;
		$mort = (float) $mort;

		$temp_composite_index = null;
		if (($prev + $detect + $morbid + $case + $mort) != 0) {
			$temp_composite_index = $prev + $detect + $morbid + $case + $mort;
		}

		$temp_probability = 0.5;
		if ($temp_composite_index !== null) {
			$exp_value = pow($this->beta_value, $temp_composite_index);
			if (($exp_value + 1) != 0) {
				$temp_probability = $exp_value / (1 + $exp_value);
			}
		}

		$temp_priority_level = $this->priorityFromProbability($temp_probability);

		$composite_index = $temp_composite_index;
		if ($composite_index !== null) {
			if ($this->matchScenario1($detect, $prev, $morbid, $case, $mort)) {
				$composite_index += 0.9;
			} elseif ($this->matchScenario2($detect, $prev, $morbid, $case, $mort)) {
				$composite_index += 1.11;
			}
		}

		$probability = 0.5;
		if ($composite_index !== null) {
			$exp_value = pow($this->beta_value, $composite_index);
			if (($exp_value + 1) != 0) {
				$probability = $exp_value / (1 + $exp_value);
			}
		}

		$priority_level = $this->priorityFromProbability($probability);

		return [
			'temp_composite_index' => $temp_composite_index,
			'temp_probability' => $temp_probability,
			'temp_priority_level' => $temp_priority_level,
			'composite_index' => $composite_index,
			'probability' => $probability,
			'priority_level' => $priority_level,
		];
	}

	/**
	 * Recalculate and persist derived fields for one ranking row.
	 */
	public function updateRecordById($recordId)
	{
		$row = $this->db->get_where('member_state_diseases_data', ['id' => $recordId])->row();
		if (!$row) {
			return false;
		}

		$metrics = $this->calculateMetrics(
			$row->detect,
			$row->prev,
			$row->morbid,
			$row->case,
			$row->mort
		);

		$metrics['updated_at'] = date('Y-m-d H:i:s');
		$this->db->where('id', $recordId);
		$this->db->update('member_state_diseases_data', $metrics);

		return true;
	}

	/**
	 * Batch recalculate all ranking rows (admin / data correction).
	 *
	 * @param bool $onlyMissing When true, only rows with NULL temp_composite_index (legacy behaviour).
	 */
	public function correct_composite_index($onlyMissing = false)
	{
		if ($onlyMissing) {
			$this->db->where('temp_composite_index IS NULL', null, false);
		}
		$rows = $this->db->select('id')->get('member_state_diseases_data')->result();
		$updated = 0;

		foreach ($rows as $row) {
			if ($this->updateRecordById($row->id)) {
				$updated++;
			}
		}

		return $updated;
	}

	private function matchScenario1($detect, $prev, $morbid, $case, $mort)
	{
		return (
			($this->isDetect('Detect1', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort2', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort2', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort2', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev1', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort2', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort2', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid1', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort2', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort2', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case1', $case) && $this->isMort('Mort2', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort2', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort1', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort3', $mort))
		);
	}

	private function matchScenario2($detect, $prev, $morbid, $case, $mort)
	{
		return (
			($this->isDetect('Detect1', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort3', $mort)) ||
			($this->isDetect('Detect2', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort3', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort3', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev1', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort3', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev2', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort3', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid1', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort3', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid2', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort3', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case1', $case) && $this->isMort('Mort3', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case2', $case) && $this->isMort('Mort3', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort1', $mort)) ||
			($this->isDetect('Detect3', $detect) && $this->isPrev('Prev3', $prev) && $this->isMorbid('Morbid3', $morbid) && $this->isCase('Case3', $case) && $this->isMort('Mort2', $mort))
		);
	}

	private function isDetect($header, $value)
	{
		return (isset($this->parameters[$header]) && abs($value - $this->parameters[$header]) < 0.001);
	}

	private function isPrev($header, $value)
	{
		return (isset($this->parameters[$header]) && abs($value - $this->parameters[$header]) < 0.001);
	}

	private function isMorbid($header, $value)
	{
		return (isset($this->parameters[$header]) && abs($value - $this->parameters[$header]) < 0.001);
	}

	private function isCase($header, $value)
	{
		return (isset($this->parameters[$header]) && abs($value - $this->parameters[$header]) < 0.001);
	}

	private function isMort($header, $value)
	{
		return (isset($this->parameters[$header]) && abs($value - $this->parameters[$header]) < 0.001);
	}
}
