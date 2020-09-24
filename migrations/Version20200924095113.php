<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200924095113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Change url field to NULL default';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__clients AS SELECT id, title, url, image_name, created_at, updated_at FROM clients');
        $this->addSql('DROP TABLE clients');
        $this->addSql('CREATE TABLE clients (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, image_name VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO clients (id, title, url, image_name, created_at, updated_at) SELECT id, title, url, image_name, created_at, updated_at FROM __temp__clients');
        $this->addSql('DROP TABLE __temp__clients');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__clients AS SELECT id, title, url, image_name, created_at, updated_at FROM clients');
        $this->addSql('DROP TABLE clients');
        $this->addSql('CREATE TABLE clients (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, url VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO clients (id, title, url, image_name, created_at, updated_at) SELECT id, title, url, image_name, created_at, updated_at FROM __temp__clients');
        $this->addSql('DROP TABLE __temp__clients');
    }
}
