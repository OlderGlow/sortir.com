<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200816205856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieux ADD Villes INT DEFAULT NULL, DROP ville_id');
        $this->addSql('ALTER TABLE lieux ADD CONSTRAINT FK_9E44A8AE1E8C9AEE FOREIGN KEY (Villes) REFERENCES villes (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_9E44A8AE1E8C9AEE ON lieux (Villes)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AE1E8C9AEE');
        $this->addSql('DROP INDEX IDX_9E44A8AE1E8C9AEE ON lieux');
        $this->addSql('ALTER TABLE lieux ADD ville_id INT NOT NULL, DROP Villes');
    }
}
