# Composite Index, Probability, and Priority Level

This document describes how disease ranking scores are derived in the prioritisation tool. Implementation lives in `application/modules/data/models/Composite_mdl.php`.

## Inputs (per disease / country / period)

Each row in `member_state_diseases_data` stores five criteria (numeric values from parameter lookup tables):

| Field | Meaning |
|-------|---------|
| `prev` | Prevention |
| `detect` | Detection |
| `morbid` | Morbidity |
| `case` | Case management |
| `mort` | Mortality |

Users set these via the ranking form (`records/load_ranking_form`, saved through `records/save_all_ranking_data`).

## Calculation pipeline

```
Criteria (prev, detect, morbid, case, mort)
        │
        ▼
┌───────────────────────────┐
│ 1. temp_composite_index   │  = sum of five criteria (if sum ≠ 0)
└───────────────────────────┘
        │
        ▼
┌───────────────────────────┐
│ 2. temp_probability       │  = β^temp / (1 + β^temp)   [default 0.5 if no index]
└───────────────────────────┘
        │
        ▼
┌───────────────────────────┐
│ 3. temp_priority_level    │  from temp_probability thresholds
└───────────────────────────┘
        │
        ▼
┌───────────────────────────┐
│ 4. composite_index        │  = temp_composite_index
│    (+ scenario boost)     │     + 0.9 (Scenario 1) OR + 1.11 (Scenario 2)
└───────────────────────────┘
        │
        ▼
┌───────────────────────────┐
│ 5. probability            │  = β^composite / (1 + β^composite)
└───────────────────────────┘
        │
        ▼
┌───────────────────────────┐
│ 6. priority_level         │  from final probability thresholds
└───────────────────────────┘
```

- **β (beta)** comes from the `beta_value` table (`is_current = 1`), default **2.718** if none set.
- **Parameter betas** in the `parameters` table define which numeric values match labels like `Detect2`, `Prev3`, etc. (used only for scenario matching).

### Probability formula

For composite index `x`:

```
probability = β^x / (1 + β^x)
```

This is a sigmoid-style mapping: higher composite index → higher probability (approaches 1).

### Priority thresholds (final and charts)

| Label | Condition on `probability` |
|-------|---------------------------|
| **High** | `probability >= 0.80` |
| **Medium** | `0.65 <= probability < 0.80` |
| **Low** | `probability < 0.65` |

Dashboard charts colour bars/gauge using the same cut-offs (80% and 65%).

**Example:** probability **0.83** → **High** (not Medium).  
**Example:** probability **0.72** → **Medium**.

## Composite index scenarios

After the initial sum, the tool may **increase** `composite_index` when criteria match predefined patterns. Only **one** boost applies (Scenario 1 checked first).

### Scenario 1 — boost **+0.9**

Triggered when the five criteria match **any** of several patterns where most dimensions are at “level 2” equivalents (e.g. Detect2, Prev2, Morbid2, Case2, Mort2), with one dimension allowed at level 1 or 3. See `Composite_mdl::matchScenario1()` for the full list of OR branches.

**Intent:** Recognise a common “moderate-high across pillars” profile and raise the composite score.

### Scenario 2 — boost **+1.11**

Triggered when criteria align with “level 3” style patterns (e.g. Detect3, Prev3, Morbid3, Case3, Mort3) across several combinations. See `Composite_mdl::matchScenario2()`.

**Intent:** Recognise a higher-risk profile and apply a larger boost than Scenario 1.

### No scenario match

`composite_index` stays equal to `temp_composite_index` (simple sum).

## Stored columns

| Column | Description |
|--------|-------------|
| `temp_composite_index` | Sum before scenario boost |
| `temp_probability` | Probability from temp index |
| `temp_priority_level` | Priority from temp probability |
| `composite_index` | Final index after scenario boost |
| `probability` | Final probability (used in charts and table) |
| `priority_level` | Final label (High / Medium / Low) |

## When values are recalculated

| Action | Behaviour |
|--------|-----------|
| Save one criterion via ranking form | `Records_model::save_ranking_data()` → `Composite_mdl::updateRecordById()` |
| Batch correction | `GET/POST` `records/data_correction` or `data/correct_composite_index` → all rows |
| Read dashboard table | `Records::get_ranking_data()` displays priority via `priorityFromProbability()` so labels match probability even before batch fix |

Previously, composite recalculation after save was **disabled** (`//correct_composite_index_async()`), and batch correction only updated rows with `temp_composite_index IS NULL`. That caused **stale `priority_level`** (e.g. old 87% High threshold) while **probability** was updated elsewhere—charts then showed “High” colours for 83% because charts use probability, not the stale column.

## Troubleshooting mismatches

| Symptom | Likely cause | Fix |
|---------|--------------|-----|
| Probability ≥ 0.80, table says Medium | Stale `priority_level` in DB | Run `records/data_correction` or re-save criteria |
| Chart red, table Medium | Charts use probability; table used old DB label | Fixed by display logic + save-time recalc |
| Scenario expected but no boost | Criteria don’t match parameter betas exactly (±0.001) | Verify `parameters` table values vs saved criteria |

## Related code references

- Model: `application/modules/data/models/Composite_mdl.php`
- Save path: `application/modules/records/models/Records_model.php`
- Table API: `application/modules/records/controllers/Records.php` → `get_ranking_data()`
- Chart colours: `application/modules/templates/views/includes/footer.php` → `renderChartByProbability()`, `renderDiseaseProbabilityGauge()`
