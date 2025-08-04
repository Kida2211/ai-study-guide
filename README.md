# AI Study Guide

This Laravel application uses the OpenAI API to help students study smarter.
Users can paste their notes and get either a summary or quiz questions.

## Features

- Submit study notes via textarea
- Choose between summary or quiz output
- Uses OpenAI GPT-3.5 API
- Clean, single-page interface

## Setup Instructions

1. Clone the repo:
   git clone https://github.com/YOUR_USERNAME/ai-study-guide.git
   cd ai-study-guide
2. Install dependencies:
composer install
3. Configure .env:
cp .env.example .env
DB_DATABASE=ai_study_guide
DB_USERNAME=root
DB_PASSWORD=
OPENAI_API_KEY=your_key_here
OPENAI_API_URL=https://api.openai.com/v1
OPENAI_MODEL=gpt-3.5-turbo

4. Migrate database(if need to)
php artisan migrate

5.run the app:
php artisan serve