<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Composite_mdl extends CI_Model
{
        protected $parameters = [];
		protected $beta_value = 2.718; // Default fallback
	
		public function __construct()
		{
			parent::__construct();
			$this->db->query('SET SESSION sql_mode = ""');
	
			// Load parameters
			$params = $this->db->get('parameters')->result();
			foreach ($params as $param) {
				$this->parameters[$param->header] = (float) $param->beta;
			}
	
			// Load current beta value
			$beta = $this->db->where('is_current', 1)->get('beta_value')->row();
			if ($beta) {
				$this->beta_value = (float) $beta->value;
			}
		}
		public function correct_composite_index()
		{
			$this->db->where('temp_composite_index IS NULL', null, false);
			$data = $this->db->get('member_state_diseases_data')->result();
		
			foreach ($data as $row) {
				$detect = $row->detect;
				$prev = $row->prev;
				$morbid = $row->morbid;
				$case = $row->case;
				$mort = $row->mort;
		
				// 1. Calculate temp_composite_index
				$temp_composite_index = null;
				if (($prev + $detect + $morbid + $case + $mort) != 0) {
					$temp_composite_index = $prev + $detect + $morbid + $case + $mort;
				}
		
				// 2. Calculate temp_probability
				$temp_probability = 0.5;
				if ($temp_composite_index !== null) {
					$exp_value = pow($this->beta_value, $temp_composite_index);
					if (($exp_value + 1) != 0) {
						$temp_probability = $exp_value / (1 + $exp_value);
					}
				}
		
				// 3. Calculate temp_priority_level
				if ($temp_probability >=0.8) {
					$temp_priority_level = 'High';
				} elseif ($temp_probability >= 0.65 && $temp_probability < 0.8) {
					$temp_priority_level = 'Medium';
				} else {
					$temp_priority_level = 'Low';
				}
		
				// 4. Handle scenarios and corrections
				$composite_index = $temp_composite_index; // Default
				if ($this->matchScenario1($detect, $prev, $morbid, $case, $mort)) {
					$composite_index += 0.9;
				
				} elseif ($this->matchScenario2($detect, $prev, $morbid, $case, $mort)) {
					$composite_index += 1.11;
				}
		
				// 5. Calculate probability from final composite_index
				$probability = 0.5;
				if ($composite_index !== null) {
					$exp_value = pow($this->beta_value, $composite_index);
					if (($exp_value + 1) != 0) {
						$probability = $exp_value / (1 + $exp_value);
					}
				}
		
				// 6. Calculate final level from final probability
				if ($probability >= 0.8) {
					$level = 'High';
				} elseif ($probability >= 0.65 && $probability < 0.8) {
					$level = 'Medium';
				} else {
					$level = 'Low';
				}
		     $data = array(
				'temp_composite_index' => $temp_composite_index,
				'temp_probability' => $temp_probability,
				'temp_priority_level' => $temp_priority_level,
				'composite_index' => $composite_index,
				'probability' => $probability,
				'priority_level' => $level,  
				'updated_at' => date('Y-m-d H:i:s')
			 );
			// dd($data);
				// 7. Update the record
				$this->db->where('id', $row->id);
				$this->db->update('member_state_diseases_data',$data);
			}
		
			echo "Composite index correction and update done successfully.";
		}
		
	
		// Database Based Scenario Matching
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
		private function isPrev($header, $value) { return (isset($this->parameters[$header]) && abs($value - $this->parameters[$header]) < 0.001); }
		private function isMorbid($header, $value) { return (isset($this->parameters[$header]) && abs($value - $this->parameters[$header]) < 0.001); }
		private function isCase($header, $value) { return (isset($this->parameters[$header]) && abs($value - $this->parameters[$header]) < 0.001); }
		private function isMort($header, $value) { return (isset($this->parameters[$header]) && abs($value - $this->parameters[$header]) < 0.001); }
	}

	