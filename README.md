# NoteVault

NoteVault is a notes, research, and academic publishing platform for university communities. It gives students, lecturers, and researchers a structured place to publish, discover, and engage with course notes, research papers, and postgraduate work, organized by institution, department, course, and field of study.

## Tech Stack

- Backend and application framework: Laravel (PHP)
- Database: MySQL
- Frontend styling: Tailwind CSS
- Search: indexed search across titles, tags, course codes, and field of study
- File storage: object storage for uploaded notes, papers, and media, referenced by file records rather than stored inline

## Core Domain Entities

- Institutions: the root tenant record; signups are verified against an institutional email domain
- Departments, Courses, Course Units: the organizational hierarchy used for browsing and filtering
- Users: students, lecturers, researchers, and administrators, one role per account, each tied to an institution
- Resources: individual notes, past papers, or study guides tied to a course unit, tagged by semester and academic year
- Resource Versions: full version history for lecturer maintained notes, including changelog and timestamp per revision
- Research Works: papers and theses, tracked separately from course resources, with field of study, license type, and status
- Reviews: structured reviewer comments and status changes on a research work, with an optional blind review flag
- Endorsements: supervisor sign off required before a research work is made publicly visible
- Engagement: a polymorphic record of downloads, upvotes, comments, and follows
- Tags: a controlled taxonomy supporting search and field of study filtering

## Core Modules

- Authentication and institution verification (email domain checks at signup, role assignment)
- Content management (upload, tagging, categorization, file handling)
- Search and discovery (filtering by institution, department, course, semester, field of study)
- Reputation and engagement (upvotes, downloads, comments, follows, contributor score)
- Lecturer versioning (edit history, changelog, version notices for older content)
- Research and review workflow (submission, reviewer assignment, structured comments, status transitions)
- Postgraduate publishing (supervisor endorsement, license selection, citation generation, public visibility controls)
- Notifications (follow based alerts for new content from a followed lecturer, researcher, or course)

## Design Principles

- Casual, student contributed course notes and formal, reputationally sensitive research publishing live in clearly separated sections of the product, with distinct navigation and visual treatment, rather than a single undifferentiated feed.
- Lecturer content is authoritative and versioned, while student content is peer driven and relies on upvotes and download counts rather than formal versioning.
- All content tables include soft delete flags and are indexed on institution, course, and creation date.
- Every content record is traceable back to an institution. No feature assumes a single tenant.

## Getting Started

```bash
# Clone and navigate to the project
git clone [repository url]
cd notevault

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure your MySQL credentials in .env, then run migrations with seed data
php artisan migrate --seed
```

Then start the app either by running the server and asset bundler separately in two terminals:

```bash
php artisan serve
npm run dev
```

or by running `composer run dev`, which uses `concurrently` to start the Laravel server, the queue worker, the Pail log viewer, and the Vite dev server together in a single terminal.

The application will be available at `http://localhost:8000`.

## Status

NoteVault is a proposed project, scoped at a product and architecture level. This restructure brings the core notes sharing product to a working baseline. Research publishing and postgraduate features are planned as a later phase, once the core notes sharing product has real usage.
