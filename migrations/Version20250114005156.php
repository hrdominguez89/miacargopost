<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250114005156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE s10_code ADD bag_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD CONSTRAINT FK_A18157CF6F5D8297 FOREIGN KEY (bag_id) REFERENCES bags (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A18157CF6F5D8297 ON s10_code (bag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE s10_code DROP CONSTRAINT FK_A18157CF6F5D8297');
        $this->addSql('DROP INDEX IDX_A18157CF6F5D8297');
        $this->addSql('ALTER TABLE s10_code DROP bag_id');
    }
}
