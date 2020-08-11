<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200811161151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AE1E8C9AEE');
        $this->addSql('ALTER TABLE lieux ADD CONSTRAINT FK_9E44A8AE1E8C9AEE FOREIGN KEY (Villes) REFERENCES villes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E85F8587AA');
        $this->addSql('ALTER TABLE sorties CHANGE etat etat enum(\'En création\', \'En cours\', \'Ouvert\', \'Fermé\', \'Annulée\')');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E85F8587AA FOREIGN KEY (Lieux) REFERENCES lieux (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AE1E8C9AEE');
        $this->addSql('ALTER TABLE lieux ADD CONSTRAINT FK_9E44A8AE1E8C9AEE FOREIGN KEY (Villes) REFERENCES villes (id)');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E85F8587AA');
        $this->addSql('ALTER TABLE sorties CHANGE etat etat VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E85F8587AA FOREIGN KEY (Lieux) REFERENCES lieux (id)');
    }
}
