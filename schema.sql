
--Daya 14/01/2026
ALTER TABLE `raw_students` ADD `is_mailsend` TINYINT NOT NULL DEFAULT '0' COMMENT '0=Not Send, 1=Send' AFTER `job_assurance`;

CREATE TABLE ai_model_recharges (
    id BIGSERIAL PRIMARY KEY,
    ai_model_id BIGINT NOT NULL,
    amount NUMERIC(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
--Daya 24/03/2026
ALTER TABLE `employees` ADD `device_id` VARCHAR(255) NULL DEFAULT NULL AFTER `is_logged_in`;

--- added by bhushan 30/04/2026 ---

CREATE TABLE brand_permissions (
    id BIGSERIAL PRIMARY KEY,

    user_id BIGINT UNIQUE,
    
    -- SEO Audit Section
    seo_overview BOOLEAN DEFAULT FALSE,
    seo_failures BOOLEAN DEFAULT FALSE,
    seo_technical BOOLEAN DEFAULT FALSE,
    seo_onpage BOOLEAN DEFAULT FALSE,
    seo_page_analysis BOOLEAN DEFAULT FALSE,
    seo_performance BOOLEAN DEFAULT FALSE,
    seo_ai_insights BOOLEAN DEFAULT FALSE,
    seo_llm_prompts BOOLEAN DEFAULT FALSE,
    seo_reports BOOLEAN DEFAULT FALSE,
    seo_analytics BOOLEAN DEFAULT FALSE,
    seo_keywords BOOLEAN DEFAULT FALSE,
    seo_backlink_tracker BOOLEAN DEFAULT FALSE,
    seo_content_strategy BOOLEAN DEFAULT FALSE,
    seo_implementation BOOLEAN DEFAULT FALSE,

    -- Pillars Section
    pillar_visibility_score BOOLEAN DEFAULT FALSE,
    pillar_visibility_trend BOOLEAN DEFAULT FALSE,
    pillar_responses BOOLEAN DEFAULT FALSE,
    pillar_competitors BOOLEAN DEFAULT FALSE,
    pillar_citations BOOLEAN DEFAULT FALSE,
    pillar_google_analytics BOOLEAN DEFAULT FALSE,
    pillar_google_search_console BOOLEAN DEFAULT FALSE,
    pillar_chat_bot BOOLEAN DEFAULT FALSE,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_seo_audit_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

ALTER TABLE brand_permissions
ADD COLUMN seo_audit_order JSON NULL,
ADD COLUMN pillar_order JSON NULL;

--- end by bhushan 30/04/2026 ---