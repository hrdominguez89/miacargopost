<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114211700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP SEQUENCE office_id_seq CASCADE');        
        $this->addSql('ALTER TABLE offices ADD is_local BOOLEAN');
        $this->addSql('ALTER TABLE offices ALTER id DROP DEFAULT');
        $this->addSql('UPDATE offices SET is_local =false');
        $this->addSql("UPDATE offices SET is_local =true WHERE impc_organisation_code = 'ARA'");
        $this->addSql('ALTER TABLE offices ALTER is_local SET NOT NULL');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE flights_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE office_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE flights');
        $this->addSql('ALTER TABLE offices DROP is_local');
        $this->addSql('CREATE SEQUENCE offices_id_seq');
        $this->addSql('SELECT setval(\'offices_id_seq\', (SELECT MAX(id) FROM offices))');
        $this->addSql('ALTER TABLE offices ALTER id SET DEFAULT nextval(\'offices_id_seq\')');
    }
}
