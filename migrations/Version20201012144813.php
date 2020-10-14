<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201012144813 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create Testimanials table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, solution_id INTEGER DEFAULT NULL, initials VARCHAR(4) NOT NULL, job VARCHAR(100) DEFAULT NULL, testimony CLOB NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('CREATE INDEX IDX_383115791C0BE183 ON testimonials (solution_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE testimonials');
    }
}
