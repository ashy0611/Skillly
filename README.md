# Skillly
Resume Assistance & Career Guidance Bot

A smart, rule-based career assistant built using Laravel, PHP, and JavaScript that analyzes resumes and suggests suitable career paths.

Think of it as a digital career compass that reads resumes, detects skills, and points users toward the right direction.

---

## Objective

To build a chatbot that:

* Analyzes uploaded resumes
* Extracts skills using rule-based logic
* Suggests relevant career paths
* Highlights missing skills
* Generates a downloadable interaction summary

---

## Core Features

### Resume Upload

* Supports PDF (extendable to DOC/DOCX)
* Secure file handling via Laravel storage

### Skill Extraction

* Keyword-based parsing
* Rule-driven matching of skills

### Career Suggestions

* Predefined career domains
* Matches user skills with career requirements

### Missing Skill Detection

* Identifies gaps between user skills and career requirements

### Report Generation

* Downloadable summary of chatbot interaction
* Clean PDF output

---

## Tech Stack

* Backend: Laravel (PHP)
* Logic Layer: Service-based rule engine
* Frontend: JavaScript
* File Handling: Laravel Storage
* Processing: PHP Text Parsing

---

## System Architecture

User → Upload Resume → Laravel Backend
↓
Text Extraction (PHP)
↓
Skill Matching Engine (Rules)
↓
Career Recommendation Logic
↓
Response + PDF Report

---

## Bot Intelligence

* Rule-based skill matching
* Predefined career domains
* Conditional responses based on:

  * Available skills
  * Missing skills
  * Skill weightage

---

## Project Structure (Simplified)

app/
├── Models/
├── Services/        # Bot logic & rules
├── Http/
storage/
├── uploads/        # Resume files
resources/
├── views/          # UI
public/

---

## Security Features

* File validation (type & size)
* Secure upload handling
* Controlled storage access

---

## Deployment Checklist

* Configure `.env` for file storage
* Run migrations & seeders
* Set correct storage permissions
* Enable file upload limits
* Optimize Laravel config

---

## Documentation Deliverables

* SRS (Software Requirement Specification)
* Technical Specification
* Database Schema
* Unit Test Cases
* Bot Decision Rules
* Deployment Guide
* User Guide

---

## How to Run

git clone <repo-url>
cd project

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan serve

---

## Future Enhancements

* AI-based skill extraction (NLP)
* Resume scoring system
* Multi-language support
* Real-time chat UI improvements
* API integration (LinkedIn, job portals)

---

## Author

Built as part of a career-focused project to bridge the gap between resumes and real-world job roles.

