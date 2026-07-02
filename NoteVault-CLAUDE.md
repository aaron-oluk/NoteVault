# CLAUDE.md — NoteVault

This file gives Claude Code persistent context for working on NoteVault across sessions.

## Project Overview

NoteVault is a notes, research, and academic publishing platform for university communities. It gives students, lecturers, and researchers a structured place to publish, discover, and engage with course notes, research papers, and postgraduate work, organized by institution, department, course, and field of study. It is forked from the VerseFountain codebase, with the writer and work entities replaced by an academic equivalent.

## Tech Stack

- Backend and application framework: Laravel (PHP)
- Database: MySQL
- Frontend styling: Tailwind CSS
- Search: indexed search across titles, tags, course codes, and field of study
- File storage: object storage for uploaded notes, papers, and media, referenced by file records rather than stored inline

## Core Domain Entities

- Institutions: root tenant record; signups are verified against an institutional email domain
- Departments, Courses, Course_Units: organizational hierarchy used for browsing and filtering
- Users: students, lecturers, researchers, and administrators, one role per account, each tied to an institution
- Resources: individual notes, past papers, or study guides tied to a course unit, tagged by semester and academic year
- Resource_Versions: full version history for lecturer maintained notes, including changelog and timestamp per revision
- Research_Works: papers and theses, tracked separately from course resources, with field of study, license type, and status
- Reviews: structured reviewer comments and status changes on a research work, with an optional blind review flag
- Endorsements: supervisor sign off required before a research work is made publicly visible
- Engagement: polymorphic record of downloads, upvotes, comments, and follows
- Tags: controlled taxonomy supporting search and field of study filtering

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

- Keep casual, student contributed course notes and formal, reputationally sensitive research publishing in clearly separated sections of the product, with distinct navigation and visual treatment. Do not blend them into a single undifferentiated feed.
- Lecturer content is authoritative and versioned. Student content is peer driven and relies on upvotes and download counts rather than formal versioning.
- All content tables should include soft delete flags and be indexed on institution, course, and creation date.
- Every content record must be traceable back to an institution. Do not build features that assume a single tenant.

## Conventions

- Follow standard Laravel conventions for models, migrations, controllers, and routes
- Reuse authentication, tagging, search, and file storage logic inherited from VerseFountain rather than rebuilding it
- New content types (for example a future content category) should follow the same pattern as Resources or Research_Works: a dedicated table, a version or engagement relationship where relevant, and institution scoped access

## Formatting Rules

- Do not use hyphens, em dashes, or en dashes in generated prose, UI copy, comments, or documentation. Use plain words or commas instead.
- Hyphens are acceptable where technically required, such as CSS utility class names, npm package names, and kebab case file or route names.
- Do not introduce or reference any company or vendor name in user facing copy unless explicitly asked to.

## Status

Proposed project, scoped at a product and architecture level, not yet built. Fastest of the related projects to bring to market given the reusable VerseFountain foundation. Research publishing and doctoral features are planned as a later phase once the core notes sharing product has real usage.
