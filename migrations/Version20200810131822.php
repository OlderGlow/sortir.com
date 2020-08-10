<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810131822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970929AA56D27');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E89AA56D27');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E85F8587AA');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C9D1C3019');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E84BD76D44');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CCC72D953');
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AE1E8C9AEE');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE inscriptions');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE sorties');
        $this->addSql('DROP TABLE villes');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970929AA56D27');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E89AA56D27');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E85F8587AA');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C9D1C3019');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E84BD76D44');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CCC72D953');
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AE1E8C9AEE');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE inscriptions');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE sorties');
        $this->addSql('DROP TABLE villes');
    }
}
