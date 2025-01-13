<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250113042705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE dispatch_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE status_dispatch_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE dispatch (id INT NOT NULL, origin_office_id INT NOT NULL, destination_office_id INT NOT NULL, postal_service_range_id INT NOT NULL, status_dispatch_id INT NOT NULL, route_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, dispatch_code VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8612665A422E8652 ON dispatch (origin_office_id)');
        $this->addSql('CREATE INDEX IDX_8612665AAE2072DE ON dispatch (destination_office_id)');
        $this->addSql('CREATE INDEX IDX_8612665ACCCCF218 ON dispatch (postal_service_range_id)');
        $this->addSql('CREATE INDEX IDX_8612665AC3AEA648 ON dispatch (status_dispatch_id)');
        $this->addSql('CREATE INDEX IDX_8612665A34ECB4E6 ON dispatch (route_id)');
        $this->addSql('CREATE TABLE status_dispatch (id INT NOT NULL, name VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE dispatch ADD CONSTRAINT FK_8612665A422E8652 FOREIGN KEY (origin_office_id) REFERENCES offices (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispatch ADD CONSTRAINT FK_8612665AAE2072DE FOREIGN KEY (destination_office_id) REFERENCES offices (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispatch ADD CONSTRAINT FK_8612665ACCCCF218 FOREIGN KEY (postal_service_range_id) REFERENCES postal_service_range (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispatch ADD CONSTRAINT FK_8612665AC3AEA648 FOREIGN KEY (status_dispatch_id) REFERENCES status_dispatch (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispatch ADD CONSTRAINT FK_8612665A34ECB4E6 FOREIGN KEY (route_id) REFERENCES routes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql("INSERT INTO status_dispatch (id,name) values (1,'OPENED'),(2,'CLOSED'),(3,'IN_TRANSIT'),(4,'ARRIVED'),(5,'CANCELED')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE dispatch_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE status_dispatch_id_seq CASCADE');
        $this->addSql('ALTER TABLE dispatch DROP CONSTRAINT FK_8612665A422E8652');
        $this->addSql('ALTER TABLE dispatch DROP CONSTRAINT FK_8612665AAE2072DE');
        $this->addSql('ALTER TABLE dispatch DROP CONSTRAINT FK_8612665ACCCCF218');
        $this->addSql('ALTER TABLE dispatch DROP CONSTRAINT FK_8612665AC3AEA648');
        $this->addSql('ALTER TABLE dispatch DROP CONSTRAINT FK_8612665A34ECB4E6');
        $this->addSql('DROP TABLE dispatch');
        $this->addSql('DROP TABLE status_dispatch');
    }
}
