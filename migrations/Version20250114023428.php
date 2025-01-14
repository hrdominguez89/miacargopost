<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250114023428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE bags_s10_code_id_seq CASCADE');
        $this->addSql('ALTER TABLE bags_s10_code DROP CONSTRAINT fk_dff5b2d16f5d8297');
        $this->addSql('ALTER TABLE bags_s10_code DROP CONSTRAINT fk_dff5b2d193f76cc9');
        $this->addSql('DROP TABLE bags_s10_code');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE bags_s10_code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bags_s10_code (id INT NOT NULL, bag_id INT NOT NULL, s10_code_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_dff5b2d193f76cc9 ON bags_s10_code (s10_code_id)');
        $this->addSql('CREATE INDEX idx_dff5b2d16f5d8297 ON bags_s10_code (bag_id)');
        $this->addSql('ALTER TABLE bags_s10_code ADD CONSTRAINT fk_dff5b2d16f5d8297 FOREIGN KEY (bag_id) REFERENCES bags (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bags_s10_code ADD CONSTRAINT fk_dff5b2d193f76cc9 FOREIGN KEY (s10_code_id) REFERENCES s10_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
