# User Guide — Disease Prioritisation Tool

## 1. Purpose

The tool helps African Union member states **prioritise diseases and conditions** by:

- Assigning diseases to a country profile
- Scoring each disease on five pillars (prevention, detection, morbidity, case management, mortality)
- Computing a **composite index**, **probability**, and **priority level** (High / Medium / Low)
- Viewing results on the **dashboard** (charts, map, data table)

## 2. Logging in and roles

- **Admin** (role 10): Can filter any region and country.
- **Country user**: Sees only their member state; region/country filters may be fixed.

Contact your administrator if you cannot see the expected country or data.

## 3. Dashboard home (`/dashboard/home`)

### 3.1 Filters

| Filter | Effect |
|--------|--------|
| Year | Reporting period — choose **All Years** to include every period in charts, map, and table |
| Region | Limits countries in the country list |
| Country | Focuses charts, map, and table on one member state (or all) |
| Thematic area | Filters by disease grouping |
| Priority level | Filters by prioritisation category |

Use **Search** (magnifying glass) to apply filters. **Reset** clears selections.

### 3.2 Charts

1. **Disease Probability Gauge** — Shows probability for the disease selected in the dropdown below the gauge.
2. **Diseases by Thematic Area** — Count of shortlisted diseases per thematic area (highest counts at top).
3. **Priority Probability Ranking** — Diseases ordered by probability (highest at top). Bar colour follows the priority key.
4. **Continental Overview** — Continental counts by thematic area (highest at top).

### 3.3 Priority key (colours)

| Colour | Meaning | Probability |
|--------|---------|-------------|
| Green | Low | Below 65% |
| Orange | Medium | 65% to below 80% |
| Red | High | 80% and above |

The **Priority Probability Ranking** chart colours bars using these rules. The **Disease Ranking Data** table **Priority Level** column uses the same rules from the stored probability.

### 3.4 Disease Ranking Data table

- Sort and search columns.
- Export **Excel**, **CSV**, **PDF**, or **Print** — exports include **all rows** matching current filters, not only the current page.
- **Status**: Draft (orange) or Final (green).

### 3.5 Africa map

Shows average disease probability by country. Colour scale: green (lower) → orange (medium) → red (higher).

## 4. Country disease profile (`/records/profile`)

Used to **assign** diseases to a country:

1. Select region and country (admins) or use your fixed country.
2. Select **thematic areas**.
3. Select diseases to assign → **Assign Selected Diseases**.
4. **View Assigned Diseases** to review or remove assignments (admins).

Notifications confirm assign/unassign actions.

## 5. Disease ranking (criteria entry)

From the dashboard (or ranking workflow linked to your deployment):

1. Choose country, year, and prioritisation category.
2. For each disease, set scores for **Prevention**, **Detection**, **Morbidity**, **Case management**, and **Mortality** from the dropdowns (parameter levels).
3. **Save draft** or **submit final** when all required fields are complete.

After save, the system recalculates composite index, probability, and priority automatically.

## 6. Understanding your results

- **Composite index** — Numeric score; may increase if a “scenario” pattern is detected (see technical doc).
- **Probability** — Value between 0 and 1 (shown as 0–100% in charts); drives priority.
- **Priority level** — High / Medium / Low from probability thresholds (see [COMPOSITE_INDEX_AND_PRIORITY.md](COMPOSITE_INDEX_AND_PRIORITY.md)).

If probability is **0.83** (83%), priority should be **High**, and the ranking chart bar should appear **red**. If the table still shows Medium after a system upgrade, ask an admin to run **data correction** (see developer guide) or re-save the row.

## 7. Getting help

- For access or wrong country scope: administrator.
- For formula or priority rules: [COMPOSITE_INDEX_AND_PRIORITY.md](COMPOSITE_INDEX_AND_PRIORITY.md).
- For technical issues: development team with URL, filters used, and a screenshot of the table row (probability + priority columns).
