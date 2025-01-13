<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250113050254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE bags_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE bags_s10_code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE status_bag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bags (id INT NOT NULL, dispatch_id INT NOT NULL, status_id INT NOT NULL, number_bag INT NOT NULL, is_final_bag BOOLEAN NOT NULL, is_certified BOOLEAN NOT NULL, weight INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1ACE9C65C774D3B9 ON bags (dispatch_id)');
        $this->addSql('CREATE INDEX IDX_1ACE9C656BF700BD ON bags (status_id)');
        $this->addSql('CREATE TABLE bags_s10_code (id INT NOT NULL, bag_id INT NOT NULL, s10_code_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DFF5B2D16F5D8297 ON bags_s10_code (bag_id)');
        $this->addSql('CREATE INDEX IDX_DFF5B2D193F76CC9 ON bags_s10_code (s10_code_id)');
        $this->addSql('CREATE TABLE status_bag (id INT NOT NULL, name VARCHAR(6) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE bags ADD CONSTRAINT FK_1ACE9C65C774D3B9 FOREIGN KEY (dispatch_id) REFERENCES dispatch (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bags ADD CONSTRAINT FK_1ACE9C656BF700BD FOREIGN KEY (status_id) REFERENCES status_bag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bags_s10_code ADD CONSTRAINT FK_DFF5B2D16F5D8297 FOREIGN KEY (bag_id) REFERENCES bags (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bags_s10_code ADD CONSTRAINT FK_DFF5B2D193F76CC9 FOREIGN KEY (s10_code_id) REFERENCES s10_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql("INSERT INTO status_bag (id,name) values (1,'OPENED'),(2,'CLOSED')");
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE bags_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE bags_s10_code_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE status_bag_id_seq CASCADE');
        $this->addSql('ALTER TABLE bags DROP CONSTRAINT FK_1ACE9C65C774D3B9');
        $this->addSql('ALTER TABLE bags DROP CONSTRAINT FK_1ACE9C656BF700BD');
        $this->addSql('ALTER TABLE bags_s10_code DROP CONSTRAINT FK_DFF5B2D16F5D8297');
        $this->addSql('ALTER TABLE bags_s10_code DROP CONSTRAINT FK_DFF5B2D193F76CC9');
        $this->addSql('DROP TABLE bags');
        $this->addSql('DROP TABLE bags_s10_code');
        $this->addSql('DROP TABLE status_bag');
    }
}
