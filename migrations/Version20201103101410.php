<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103101410 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create users table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('DROP INDEX IDX_383115791C0BE183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__testimonials AS SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM testimonials');
        $this->addSql('DROP TABLE testimonials');
        $this->addSql('CREATE TABLE testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, solution_id INTEGER NOT NULL, initials VARCHAR(4) NOT NULL COLLATE BINARY, job VARCHAR(100) DEFAULT NULL COLLATE BINARY, testimony CLOB NOT NULL COLLATE BINARY, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_383115791C0BE183 FOREIGN KEY (solution_id) REFERENCES solutions (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO testimonials (id, solution_id, initials, job, testimony, created_at, updated_at) SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM __temp__testimonials');
        $this->addSql('DROP TABLE __temp__testimonials');
        $this->addSql('CREATE INDEX IDX_383115791C0BE183 ON testimonials (solution_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP INDEX IDX_383115791C0BE183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__testimonials AS SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM testimonials');
        $this->addSql('DROP TABLE testimonials');
        $this->addSql('CREATE TABLE testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, solution_id INTEGER NOT NULL, initials VARCHAR(4) NOT NULL, job VARCHAR(100) DEFAULT NULL, testimony CLOB NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO testimonials (id, solution_id, initials, job, testimony, created_at, updated_at) SELECT id, solution_id, initials, job, testimony, created_at, updated_at FROM __temp__testimonials');
        $this->addSql('DROP TABLE __temp__testimonials');
        $this->addSql('CREATE INDEX IDX_383115791C0BE183 ON testimonials (solution_id)');
    }
}
