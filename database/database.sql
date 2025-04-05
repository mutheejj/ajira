-- Create Ajira database
CREATE DATABASE IF NOT EXISTS ajiraglobal;
USE ajiraglobal;

-- Create users table
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('client', 'job-seeker') DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `company_size` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `skills` json DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `portfolio` varchar(255) DEFAULT NULL,
  `github_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `personal_website` varchar(255) DEFAULT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'KSH',
  `portfolio_description` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Create job_posts table
CREATE TABLE `job_posts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `skills` json NOT NULL,
  `experience_level` enum('entry', 'intermediate', 'expert') NOT NULL,
  `project_type` enum('full_time', 'part_time', 'contract', 'freelance') NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `currency` enum('KSH', 'USD') NOT NULL DEFAULT 'KSH',
  `duration` int(11) NOT NULL COMMENT 'Duration in days',
  `location` varchar(255) DEFAULT NULL,
  `remote_work` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active', 'closed', 'draft') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `job_posts_client_id_foreign` (`client_id`),
  CONSTRAINT `job_posts_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- Create job_applications table
CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_seeker_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `status` enum('pending', 'reviewing', 'interviewed', 'rejected', 'accepted') NOT NULL DEFAULT 'pending',
  `current_step` int(11) NOT NULL DEFAULT 0,
  `steps` json NOT NULL DEFAULT (JSON_ARRAY()),
  `applied_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_applications_job_seeker_id_job_id_unique` (`job_seeker_id`,`job_id`),
  KEY `job_applications_job_id_foreign` (`job_id`),
  CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `job_applications_job_seeker_id_foreign` FOREIGN KEY (`job_seeker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- Create saved_jobs table
CREATE TABLE `saved_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_seeker_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `saved_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `saved_jobs_job_seeker_id_job_id_unique` (`job_seeker_id`,`job_id`),
  KEY `saved_jobs_job_id_foreign` (`job_id`),
  CONSTRAINT `saved_jobs_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `saved_jobs_job_seeker_id_foreign` FOREIGN KEY (`job_seeker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- Create email_verifications table
CREATE TABLE `email_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_verifications_user_id_foreign` (`user_id`),
  CONSTRAINT `email_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- Insert sample data

-- Sample Users
INSERT INTO `users` 
(`name`, `email`, `password`, `user_type`, `company_name`, `industry`, `company_size`, 
`website`, `description`, `profession`, `experience`, `skills`, `bio`, `currency`, 
`created_at`, `updated_at`) 
VALUES
-- Clients
('Tech Solutions', 'tech@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client', 
'Tech Solutions Ltd', 'Information Technology', '50-100', 
'https://techsolutions.example.com', 'Leading tech solutions provider', NULL, NULL, NULL, NULL, 'KSH',
NOW(), NOW()),

('Global Marketing', 'global@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client', 
'Global Marketing Inc', 'Marketing', '10-50', 
'https://globalmarketing.example.com', 'International marketing agency', NULL, NULL, NULL, NULL, 'USD',
NOW(), NOW()),

('Nairobi Designs', 'designs@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client', 
'Nairobi Designs', 'Design', '5-10', 
'https://nairobidesigns.example.com', 'Creative design studio based in Nairobi', NULL, NULL, NULL, NULL, 'KSH',
NOW(), NOW()),

-- Job Seekers
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'job-seeker', 
NULL, NULL, NULL, NULL, NULL, 'Software Developer', '5 years', 
'["PHP", "Laravel", "JavaScript", "Vue.js", "MySQL"]', 'Experienced software developer with focus on web applications', 'KSH',
NOW(), NOW()),

('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'job-seeker', 
NULL, NULL, NULL, NULL, NULL, 'UX/UI Designer', '3 years', 
'["UI Design", "UX Research", "Figma", "Adobe XD", "Prototyping"]', 'Creative designer passionate about user experience', 'USD',
NOW(), NOW()),

('David Mwangi', 'david@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'job-seeker', 
NULL, NULL, NULL, NULL, NULL, 'Digital Marketer', '2 years', 
'["SEO", "Content Marketing", "Social Media", "Google Analytics", "Email Marketing"]', 'Results-driven digital marketer', 'KSH',
NOW(), NOW());

-- Sample Job Posts
INSERT INTO `job_posts` 
(`client_id`, `title`, `category`, `description`, `requirements`, `skills`, `experience_level`, 
`project_type`, `budget`, `currency`, `duration`, `location`, `remote_work`, `status`, 
`created_at`, `updated_at`) 
VALUES
(1, 'Senior PHP Developer', 'Web Development', 
'We are looking for a senior PHP developer to join our team and work on a large-scale web application.',
'- At least 5 years of PHP experience\n- Proficiency in Laravel framework\n- Experience with database design and optimization\n- Familiarity with frontend technologies',
'["PHP", "Laravel", "MySQL", "JavaScript", "Git"]', 'expert', 'full_time', 8000.00, 'KSH', 90, 'Nairobi', 0, 'active',
NOW(), NOW()),

(1, 'Frontend React Developer', 'Web Development', 
'Join our team to build modern, responsive web interfaces using React and related technologies.',
'- Strong proficiency in JavaScript and React\n- Experience with state management libraries\n- Understanding of responsive design principles\n- Knowledge of modern frontend build tools',
'["React", "JavaScript", "CSS", "Redux", "Webpack"]', 'intermediate', 'contract', 5000.00, 'KSH', 60, 'Nairobi', 1, 'active',
NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY),

(2, 'Social Media Manager', 'Digital Marketing', 
'We are seeking a creative and data-driven social media manager to handle our clients\' social presence.',
'- Experience managing social media accounts for businesses\n- Knowledge of social media analytics tools\n- Creative content creation abilities\n- Understanding of paid social advertising',
'["Social Media Marketing", "Content Creation", "Analytics", "Copywriting", "Campaign Management"]', 'intermediate', 'part_time', 3000.00, 'USD', 30, 'Remote', 1, 'active',
NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY),

(3, 'UI/UX Designer', 'UI/UX Design', 
'Looking for a talented UI/UX designer to create beautiful and functional interfaces for our clients.',
'- Portfolio demonstrating UI/UX design skills\n- Proficiency in design tools like Figma or Adobe XD\n- Understanding of user-centered design principles\n- Experience conducting user research and usability testing',
'["UI Design", "UX Design", "Figma", "Prototyping", "User Testing"]', 'intermediate', 'freelance', 4000.00, 'KSH', 45, 'Nairobi', 1, 'active',
NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY),

(2, 'Content Writer', 'Content Writing', 
'We need a skilled content writer to create engaging blog posts, articles, and website copy for our clients.',
'- Excellent English writing skills\n- SEO knowledge\n- Ability to write in different tones and styles\n- Research skills to write about various industries',
'["Content Writing", "SEO", "Copywriting", "Blogging", "Research"]', 'entry', 'freelance', 2000.00, 'USD', 30, 'Remote', 1, 'active',
NOW() - INTERVAL 4 DAY, NOW() - INTERVAL 4 DAY),

(3, 'Mobile App Developer', 'Mobile Development', 
'Seeking a mobile app developer to build a cross-platform application using Flutter.',
'- Experience with Flutter and Dart\n- Knowledge of mobile app architecture\n- Understanding of RESTful APIs\n- Experience with app store deployment',
'["Flutter", "Dart", "Mobile Development", "API Integration", "Firebase"]', 'intermediate', 'contract', 6000.00, 'KSH', 60, 'Nairobi', 0, 'active',
NOW() - INTERVAL 5 DAY, NOW() - INTERVAL 5 DAY),

(1, 'Data Scientist', 'Data Science', 
'Looking for a data scientist to help analyze customer data and build predictive models.',
'- Strong statistical knowledge\n- Experience with machine learning algorithms\n- Proficiency in Python and data analysis libraries\n- Data visualization skills',
'["Python", "Machine Learning", "Data Analysis", "Statistics", "Data Visualization"]', 'expert', 'full_time', 9000.00, 'KSH', 90, 'Nairobi', 0, 'draft',
NOW() - INTERVAL 6 DAY, NOW() - INTERVAL 6 DAY);

-- Sample Job Applications
INSERT INTO `job_applications` 
(`job_seeker_id`, `job_id`, `cover_letter`, `status`, `current_step`, `steps`, 
`applied_date`, `last_updated`, `created_at`, `updated_at`) 
VALUES
(4, 1, 'I am excited to apply for the Senior PHP Developer position. With over 5 years of experience in PHP and Laravel development, I believe I would be a great fit for your team. My experience includes building and maintaining large-scale web applications, optimizing database performance, and implementing modern frontend technologies.', 
'reviewing', 1, '["Application Submitted", "Resume Review", "Interview", "Decision"]',
NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 1 DAY),

(4, 2, 'I would like to express my interest in the Frontend React Developer position. Although my primary expertise is in PHP, I have been working with React for the past two years and have developed several projects using React and Redux. I am particularly interested in this position as it would allow me to focus more on frontend development.',
'pending', 0, '["Application Submitted", "Resume Review", "Interview", "Decision"]',
NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY),

(5, 3, 'I am applying for the Social Media Manager position. With 3 years of experience in managing social media accounts for various businesses, I have developed a deep understanding of different platforms and strategies to increase engagement and conversion. I am particularly skilled in creating content that resonates with target audiences and analyzing performance metrics to optimize campaigns.',
'interviewed', 2, '["Application Submitted", "Resume Review", "Interview", "Decision"]',
NOW() - INTERVAL 3 DAY, NOW(), NOW() - INTERVAL 3 DAY, NOW()),

(5, 4, 'As a UX/UI Designer with a passion for creating intuitive and visually appealing interfaces, I am excited to apply for this position. My portfolio includes work for clients in various industries, and I specialize in creating designs that not only look good but also enhance the user experience. I am proficient in Figma and have experience conducting user testing to refine designs.',
'accepted', 3, '["Application Submitted", "Resume Review", "Interview", "Decision"]',
NOW() - INTERVAL 5 DAY, NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 5 DAY, NOW() - INTERVAL 1 DAY),

(6, 5, 'I am applying for the Content Writer position. With 2 years of experience creating various types of content including blog posts, articles, and website copy, I have developed strong writing skills and an understanding of SEO principles. I am able to adapt my writing style to different audiences and industries, and I take pride in delivering high-quality content that engages readers.',
'rejected', 2, '["Application Submitted", "Resume Review", "Interview", "Decision"]',
NOW() - INTERVAL 4 DAY, NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 4 DAY, NOW() - INTERVAL 1 DAY);

-- Sample Saved Jobs
INSERT INTO `saved_jobs` 
(`job_seeker_id`, `job_id`, `saved_date`, `created_at`, `updated_at`) 
VALUES
(4, 3, NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY),
(4, 6, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY),
(5, 2, NOW() - INTERVAL 4 DAY, NOW() - INTERVAL 4 DAY, NOW() - INTERVAL 4 DAY),
(5, 6, NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY),
(6, 1, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY);

-- Sample Email Verifications
INSERT INTO `email_verifications` 
(`user_id`, `code`, `expires_at`, `created_at`, `updated_at`) 
VALUES
(4, '123456', NOW() + INTERVAL 24 HOUR, NOW(), NOW()),
(5, '234567', NOW() + INTERVAL 24 HOUR, NOW(), NOW()),
(6, '345678', NOW() + INTERVAL 24 HOUR, NOW(), NOW());