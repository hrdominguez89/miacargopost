<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241115073020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE flights_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE routes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE segments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE flights (id INT NOT NULL, origin_airport VARCHAR(3) NOT NULL, arrival_airport VARCHAR(3) NOT NULL, flight_number VARCHAR(7) NOT NULL, flight_frequency VARCHAR(7) NOT NULL, departure_time TIME(0) WITHOUT TIME ZONE NOT NULL, arrival_time TIME(0) WITHOUT TIME ZONE NOT NULL, aircraft_type VARCHAR(6) NOT NULL, effective_date DATE NOT NULL, discontinue_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE routes (id INT NOT NULL, postal_service_id INT NOT NULL, origin_office_id INT NOT NULL, destination_office_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_32D5C2B3E5BF93D8 ON routes (postal_service_id)');
        $this->addSql('CREATE INDEX IDX_32D5C2B3422E8652 ON routes (origin_office_id)');
        $this->addSql('CREATE INDEX IDX_32D5C2B3AE2072DE ON routes (destination_office_id)');
        $this->addSql('CREATE TABLE segments (id INT NOT NULL, route_id INT NOT NULL, flight_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_26CEDB2934ECB4E6 ON segments (route_id)');
        $this->addSql('CREATE INDEX IDX_26CEDB2991F478C5 ON segments (flight_id)');
        $this->addSql('ALTER TABLE routes ADD CONSTRAINT FK_32D5C2B3E5BF93D8 FOREIGN KEY (postal_service_id) REFERENCES postal_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE routes ADD CONSTRAINT FK_32D5C2B3422E8652 FOREIGN KEY (origin_office_id) REFERENCES offices (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE routes ADD CONSTRAINT FK_32D5C2B3AE2072DE FOREIGN KEY (destination_office_id) REFERENCES offices (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE segments ADD CONSTRAINT FK_26CEDB2934ECB4E6 FOREIGN KEY (route_id) REFERENCES routes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE segments ADD CONSTRAINT FK_26CEDB2991F478C5 FOREIGN KEY (flight_id) REFERENCES flights (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE flights_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE routes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE segments_id_seq CASCADE');
        $this->addSql('ALTER TABLE routes DROP CONSTRAINT FK_32D5C2B3E5BF93D8');
        $this->addSql('ALTER TABLE routes DROP CONSTRAINT FK_32D5C2B3422E8652');
        $this->addSql('ALTER TABLE routes DROP CONSTRAINT FK_32D5C2B3AE2072DE');
        $this->addSql('ALTER TABLE segments DROP CONSTRAINT FK_26CEDB2934ECB4E6');
        $this->addSql('ALTER TABLE segments DROP CONSTRAINT FK_26CEDB2991F478C5');
        $this->addSql('DROP TABLE flights');
        $this->addSql('DROP TABLE routes');
        $this->addSql('DROP TABLE segments');
    }
}
