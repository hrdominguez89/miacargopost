<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202065346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE routes DROP CONSTRAINT fk_32d5c2b3e5bf93d8');
        $this->addSql('DROP INDEX idx_32d5c2b3e5bf93d8');
        $this->addSql('ALTER TABLE routes DROP postal_service_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE routes ADD postal_service_id INT NOT NULL');
        $this->addSql('ALTER TABLE routes ADD CONSTRAINT fk_32d5c2b3e5bf93d8 FOREIGN KEY (postal_service_id) REFERENCES postal_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_32d5c2b3e5bf93d8 ON routes (postal_service_id)');
    }
}
