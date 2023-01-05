<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230105120610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cheese_listing (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, price INTEGER NOT NULL, create_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL)');
        $this->addSql('DROP TABLE home');
        $this->addSql('DROP TABLE renter');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE home (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, renter_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, surface DOUBLE PRECISION NOT NULL, place VARCHAR(255) NOT NULL COLLATE BINARY, price INTEGER NOT NULL, equipments CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:array)
        )');
        $this->addSql('CREATE INDEX IDX_71D60CD0E289A545 ON home (renter_id)');
        $this->addSql('CREATE TABLE renter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, firstname VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('DROP TABLE cheese_listing');
    }
}
