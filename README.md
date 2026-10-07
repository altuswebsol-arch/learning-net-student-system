# Learning Net — Student Management System

A WordPress plugin that powers a complete online tutoring platform: student registration with admin verification, teacher dashboards, timetables, two-way messaging and progress tracking.

## Features

- **Student registration** — `[ln_student_register]` shortcode with fee-slip upload; admin approve/reject flow (Users → Student Verifications)
- **Protected student dashboard** — My Lessons, Book a Lesson, Progress Reports, Messages, Learning Resources, My Account, official timetable
- **Teacher system** — `[ln_teacher_dashboard]`, teacher login, admin-assigned students only (teachers see just their allotted students)
- **Timetable editor** — set by admin or teacher (students never set their own)
- **Two-way messaging** — teacher ↔ student threads stored per-student (AJAX)
- **Practice scores** — persisted per student, visible in Progress Reports
- **Roles** — Pending Student / Student roles with proper capability gating; logged-out visitors redirect to login

## Tech stack

- PHP (WordPress plugin, custom roles, AJAX handlers, custom DB tables)
- Vanilla JS + CSS (dashboard UI)

## Shortcodes

| Shortcode | Page |
|---|---|
| `[ln_student_register]` | Registration (fee-slip upload) |
| `[ln_student_login]` | Student login |
| `[ln_student_dashboard]` | Protected student area |
| `[ln_teacher_login]` | Teacher login |
| `[ln_teacher_dashboard]` | Teacher area |

## Install

1. Upload to `wp-content/plugins/` and activate
2. Create pages with the shortcodes above
3. Approve students under Users → Student Verifications, assign teachers via the student profile
