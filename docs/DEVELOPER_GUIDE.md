# Developer Guide — Disease Prioritisation Tool

## 1. Stack

| Layer | Technology |
|-------|------------|
| Framework | CodeIgniter 3 |
| Modules | HMVC (`application/modules/*`) |
| Database | MySQL / MariaDB (`priotisation_tool.sql`) |
| Frontend | jQuery, Bootstrap, DataTables, Highcharts, Lobibox |
| PHP | 8.x recommended |

Entry point: `index.php`  
Base URL example: `http://localhost/priotisation_tool/`

## 2. Module map

| Module | Path | Responsibility |
|--------|------|----------------|
| `dashboard` | `application/modules/dashboard/` | Dashboard home view |
| `records` | `application/modules/records/` | Ranking data, charts API, assignments, DataTables |
| `data` | `application/modules/data/` | Generic data admin, **composite recalculation** |
| `lists` | `application/modules/lists/` | Diseases, thematic areas, countries, regions |
| `parameters` | `application/modules/parameters/` | Criteria parameter betas |
| `auth` | `application/modules/auth/` | Login, sessions |
| `templates` | `application/modules/templates/` | Layout, header, footer (shared JS) |
| `account` | `application/modules/account/` | User accounts |

## 3. Core data tables

| Table | Role |
|-------|------|
| `member_state_diseases_data` | Ranking rows: criteria + composite + probability + priority |
| `member_state_diseases` | Country ↔ disease assignments |
| `diseases_and_conditions` | Master disease list |
| `disease_thematic_areas` | Thematic grouping |
| `member_states`, `regions` | Geography |
| `priotisation_category` | Priority level filter dimension |
| `parameters` | Beta values per criterion header (Detect1, Prev2, …) |
| `beta_value` | Global β for probability formula |

## 4. Request flow — ranking save

```
Browser POST records/save_all_ranking_data
  → Records::save_all_ranking_data()
  → Records_model::save_all_ranking_data()
  → Records_model::save_ranking_data()  // updates prev|detect|morbid|case|mort
  → Composite_mdl::updateRecordById()     // recalculates all derived fields
```

**Important:** Composite logic is centralized in `Composite_mdl`. Do not duplicate thresholds in controllers.

## 5. Request flow — dashboard table

```
DataTables POST records/get_ranking_data
  → Server-side paging, filters (region, country, period, thematic, category)
  → priority_level for display: composite_mdl->priorityFromProbability(probability)
```

## 6. Request flow — charts (footer JS)

Shared functions in `application/modules/templates/views/includes/footer.php`:

| Function | Endpoint | Chart ID |
|----------|----------|----------|
| `renderChartByThematicArea` | `records/get_disease_chart_data` | `priority-disease-chart` |
| `renderChartByProbability` | `records/get_disease_probability_chart_data` | `priority-probability-chart` |
| `renderContinentalChart` | `records/get_continental_disease_chart_data` | `continental-disease-chart` |
| `renderDiseaseProbabilityGauge` | `records/get_disease_probability_gauge` | `disease-probability-gauge` |

Chart colour thresholds must stay aligned with `Composite_mdl::priorityFromProbability()` (80% / 65%).

## 7. Composite index maintenance

| Endpoint | Controller | Effect |
|----------|------------|--------|
| `records/data_correction` | `Records::data_correction()` | JSON; recalculates **all** rows |
| `data/correct_composite_index` | `Data::correct_composite_index()` | Plain text; same batch job |

```php
$this->composite_mdl->correct_composite_index(false); // all rows
$this->composite_mdl->correct_composite_index(true);  // legacy: only NULL temp_composite_index
```

Single-row update:

```php
$this->composite_mdl->updateRecordById($recordId);
```

See [COMPOSITE_INDEX_AND_PRIORITY.md](COMPOSITE_INDEX_AND_PRIORITY.md) for formulas and scenarios.

## 8. Autoloaded models

`application/config/autoload.php`:

```php
$autoload['model'] = array(
  'lists/lists_mdl' => 'lists_mdl',
  'data/composite_mdl' => 'composite_mdl'
);
```

`Records_model` also loads `composite_mdl` in its constructor for saves.

## 9. Local setup

1. Import `priotisation_tool.sql`.
2. Configure database in `application/config/database.php` or `.env` as used in your environment.
3. Point Apache/vhost document root to project folder; ensure `mod_rewrite` / `.htaccess`.
4. Install PHP deps: `composer install` (if used).

## 10. Coding conventions

- Keep **priority thresholds** in `Composite_mdl::priorityFromProbability()` only.
- After changing criteria save logic, always call `updateRecordById()`.
- DataTables exports: custom buttons fetch `length = recordsDisplay` (all filtered rows).
- Highcharts: use jsDelivr CDN URLs in header/footer (avoid blocked `code.highcharts.com`).

## 11. Useful debugging

- Enable CI log: `application/config/config.php` → `log_threshold`
- Inspect last query in model: `$this->db->last_query()`
- Test ranking API: POST `records/get_ranking_data` with `draw`, `start`, `length`, filter fields
- Verify row: `SELECT probability, priority_level FROM member_state_diseases_data WHERE id = ?`

## 12. Documentation index

- [USER_GUIDE.md](USER_GUIDE.md)
- [COMPOSITE_INDEX_AND_PRIORITY.md](COMPOSITE_INDEX_AND_PRIORITY.md)
- [README.md](README.md) (this folder)
