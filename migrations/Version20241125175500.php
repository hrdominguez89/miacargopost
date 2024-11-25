<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125175500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');        
        $this->addSql('CREATE TABLE client (id INT NOT NULL, name VARCHAR(100) NOT NULL, type_document VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, telephone VARCHAR(15) NOT NULL, PRIMARY KEY(id))');       
        $this->addSql('ALTER TABLE offices ALTER is_local SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');        
        $this->addSql('DROP TABLE client');       
        $this->addSql('ALTER TABLE offices ALTER is_local DROP NOT NULL');
    }
}
