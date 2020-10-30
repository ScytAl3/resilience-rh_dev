<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201030123814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_383115791C0BE183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__testimonials AS SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM testimonials');
        $this->addSql('DROP TABLE testimonials');
        $this->addSql('CREATE TABLE testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, solution_id INTEGER NOT NULL, initials VARCHAR(4) NOT NULL COLLATE BINARY, job VARCHAR(100) DEFAULT NULL COLLATE BINARY, testimony CLOB NOT NULL COLLATE BINARY, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_383115791C0BE183 FOREIGN KEY (solution_id) REFERENCES solutions (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO testimonials (id, solution_id, initials, job, testimony, created_at, updated_at) SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM __temp__testimonials');
        $this->addSql('DROP TABLE __temp__testimonials');
        $this->addSql('CREATE INDEX IDX_383115791C0BE183 ON testimonials (solution_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trainings AS SELECT id, title, human_resources, created_at, updated_at, description, public, pedagogie, prerequis, evaluation, lieu, duree, langue, intervenant, contact FROM trainings');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('CREATE TABLE trainings (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, human_resources BOOLEAN DEFAULT \'1\' NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, description CLOB NOT NULL COLLATE BINARY, public CLOB NOT NULL COLLATE BINARY, pedagogie CLOB NOT NULL COLLATE BINARY, prerequis CLOB DEFAULT \'Aucun.\' NOT NULL COLLATE BINARY, evaluation CLOB NOT NULL COLLATE BINARY, lieu CLOB NOT NULL COLLATE BINARY, duree CLOB NOT NULL COLLATE BINARY, langue VARCHAR(255) NOT NULL COLLATE BINARY, intervenant CLOB NOT NULL COLLATE BINARY, contact CLOB NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO trainings (id, title, human_resources, created_at, updated_at, description, public, pedagogie, prerequis, evaluation, lieu, duree, langue, intervenant, contact) SELECT id, title, human_resources, created_at, updated_at, description, public, pedagogie, prerequis, evaluation, lieu, duree, langue, intervenant, contact FROM __temp__trainings');
        $this->addSql('DROP TABLE __temp__trainings');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_383115791C0BE183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__testimonials AS SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM testimonials');
        $this->addSql('DROP TABLE testimonials');
        $this->addSql('CREATE TABLE testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, solution_id INTEGER NOT NULL, initials VARCHAR(4) NOT NULL, job VARCHAR(100) DEFAULT NULL, testimony CLOB NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO testimonials (id, solution_id, initials, job, testimony, created_at, updated_at) SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM __temp__testimonials');
        $this->addSql('DROP TABLE __temp__testimonials');
        $this->addSql('CREATE INDEX IDX_383115791C0BE183 ON testimonials (solution_id)');
        $this->addSql('ALTER TABLE trainings ADD COLUMN pdf_filename VARCHAR(255) DEFAULT NULL COLLATE BINARY');
    }
}
