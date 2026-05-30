# Africa CDC Disease Prioritisation Tool — Documentation

This folder contains guides for the **Disease Prioritisation Tool** (CodeIgniter 3, HMVC modules).

| Document | Audience | Purpose |
|----------|----------|---------|
| [USER_GUIDE.md](USER_GUIDE.md) | Country users, regional admins, programme staff | How to use the dashboard, ranking, and profiles |
| [DEVELOPER_GUIDE.md](DEVELOPER_GUIDE.md) | Engineers | Architecture, modules, APIs, deployment |
| [COMPOSITE_INDEX_AND_PRIORITY.md](COMPOSITE_INDEX_AND_PRIORITY.md) | Analysts + developers | How composite index, probability, and priority are calculated |

## Quick links

- Dashboard home: `/dashboard/home`
- Country disease profile: `/records/profile`
- Data correction (recalculate all rows): `/records/data_correction` (admin)

## Priority vs probability (short answer)

The **table** and **charts** must use the same rules:

| Priority | Probability (decimal) | Chart colour key |
|----------|----------------------|------------------|
| High | ≥ 0.80 (80%) | Red `#CE1126` |
| Medium | 0.65 – 0.799… | Orange `#E79536` |
| Low | &lt; 0.65 | Green `#007749` |

If you see probability **0.83** labelled **Medium** in an old export, the row was likely saved before recalculation. Saving ranking criteria again or running **data correction** updates `priority_level` to match probability.
