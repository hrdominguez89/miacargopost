<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127052604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE route_service_range_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE route_service_range (id INT NOT NULL, routes_id INT NOT NULL, service_range_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_692CAADEAE2C16DC ON route_service_range (routes_id)');
        $this->addSql('CREATE INDEX IDX_692CAADED3F48B8C ON route_service_range (service_range_id)');
        $this->addSql('ALTER TABLE route_service_range ADD CONSTRAINT FK_692CAADEAE2C16DC FOREIGN KEY (routes_id) REFERENCES routes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE route_service_range ADD CONSTRAINT FK_692CAADED3F48B8C FOREIGN KEY (service_range_id) REFERENCES postal_service_range (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX unique_flight ON flights (origin_airport, arrival_airport, flight_frequency, departure_time, arrival_time, aircraft_type, flight_number, effective_date, discontinue_date)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE route_service_range_id_seq CASCADE');
        $this->addSql('ALTER TABLE route_service_range DROP CONSTRAINT FK_692CAADEAE2C16DC');
        $this->addSql('ALTER TABLE route_service_range DROP CONSTRAINT FK_692CAADED3F48B8C');
        $this->addSql('DROP TABLE route_service_range');
        $this->addSql('DROP INDEX unique_flight');
    }
}
