<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115151238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP deleted');
        $this->addSql('ALTER TABLE color DROP deleted');
        $this->addSql('ALTER TABLE experience DROP deleted');
        $this->addSql('ALTER TABLE feature DROP deleted');
        $this->addSql('ALTER TABLE formation DROP deleted');
        $this->addSql('ALTER TABLE menu DROP deleted');
        $this->addSql('ALTER TABLE project DROP deleted');
        $this->addSql('ALTER TABLE role DROP deleted');
        $this->addSql('ALTER TABLE skill DROP deleted');
        $this->addSql('ALTER TABLE tag DROP deleted');
        $this->addSql('ALTER TABLE user DROP deleted');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `category` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `color` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `experience` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `feature` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `formation` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `menu` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `project` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `role` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `skill` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `tag` ADD deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD deleted TINYINT(1) NOT NULL');
    }
}
