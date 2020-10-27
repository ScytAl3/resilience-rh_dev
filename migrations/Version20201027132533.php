<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027132533 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Update trainings table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_383115791C0BE183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__testimonials AS SELECT id, initials, job, testimony, created_at, updated_at, solution_id FROM testimonials');
        $this->addSql('DROP TABLE testimonials');
        $this->addSql('CREATE TABLE testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, solution_id INTEGER NOT NULL, initials VARCHAR(4) NOT NULL COLLATE BINARY, job VARCHAR(100) DEFAULT NULL COLLATE BINARY, testimony CLOB NOT NULL COLLATE BINARY, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_383115791C0BE183 FOREIGN KEY (solution_id) REFERENCES solutions (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO testimonials (id, initials, job, testimony, created_at, updated_at, solution_id) SELECT id, initials, job, testimony, created_at, updated_at, solution_id FROM __temp__testimonials');
        $this->addSql('DROP TABLE __temp__testimonials');
        $this->addSql('CREATE INDEX IDX_383115791C0BE183 ON testimonials (solution_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trainings AS SELECT id, title, description, pdf_filename, human_resources, created_at, updated_at FROM trainings');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('CREATE TABLE trainings (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, pdf_filename VARCHAR(255) NOT NULL COLLATE BINARY, human_resources BOOLEAN DEFAULT \'1\' NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, description CLOB NOT NULL, public CLOB NOT NULL, pedagogie CLOB NOT NULL, prerequis CLOB DEFAULT \'Aucun.\' NOT NULL, evaluation CLOB NOT NULL, lieu CLOB NOT NULL, duree CLOB NOT NULL, langue VARCHAR(255) NOT NULL, intervenant CLOB NOT NULL, contact CLOB NOT NULL)');
        $this->addSql('INSERT INTO trainings (id, title, description, pdf_filename, human_resources, created_at, updated_at) SELECT id, title, description, pdf_filename, human_resources, created_at, updated_at FROM __temp__trainings');
        $this->addSql('DROP TABLE __temp__trainings');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_383115791C0BE183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__testimonials AS SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM testimonials');
        $this->addSql('DROP TABLE testimonials');
        $this->addSql('CREATE TABLE testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, initials VARCHAR(4) NOT NULL, job VARCHAR(100) DEFAULT NULL, testimony CLOB NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, solution_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO testimonials (id, solution_id, initials, job, testimony, created_at, updated_at) SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM __temp__testimonials');
        $this->addSql('DROP TABLE __temp__testimonials');
        $this->addSql('CREATE INDEX IDX_383115791C0BE183 ON testimonials (solution_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trainings AS SELECT id, title, human_resources, description, pdf_filename, created_at, updated_at FROM trainings');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('CREATE TABLE trainings (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, human_resources BOOLEAN DEFAULT \'1\' NOT NULL, pdf_filename VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, description CLOB DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO trainings (id, title, human_resources, description, pdf_filename, created_at, updated_at) SELECT id, title, human_resources, description, pdf_filename, created_at, updated_at FROM __temp__trainings');
        $this->addSql('DROP TABLE __temp__trainings');
    }
}
