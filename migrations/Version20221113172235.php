<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221113172235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `category` (id INT AUTO_INCREMENT NOT NULL, colors_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_64C19C15C002039 (colors_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `color` (id INT AUTO_INCREMENT NOT NULL, feature_id INT DEFAULT NULL, color VARCHAR(7) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_665648E960E4B879 (feature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `experience` (id INT AUTO_INCREMENT NOT NULL, colors_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, company VARCHAR(100) NOT NULL, place VARCHAR(100) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, description LONGTEXT NOT NULL, actually TINYINT(1) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_590C1035C002039 (colors_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience_skill (experience_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_3D6F986146E90E27 (experience_id), INDEX IDX_3D6F98615585C142 (skill_id), PRIMARY KEY(experience_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `feature` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `formation` (id INT AUTO_INCREMENT NOT NULL, colors_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, school VARCHAR(100) NOT NULL, place VARCHAR(100) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, description LONGTEXT NOT NULL, actually TINYINT(1) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_404021BF5C002039 (colors_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_skill (formation_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_28B67A025200282E (formation_id), INDEX IDX_28B67A025585C142 (skill_id), PRIMARY KEY(formation_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `menu` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, link VARCHAR(50) NOT NULL, actived TINYINT(1) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `project` (id INT AUTO_INCREMENT NOT NULL, categories_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, description LONGTEXT NOT NULL, cover VARCHAR(250) NOT NULL, content LONGTEXT NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2FB3D0EEA21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_tag (project_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_91F26D60166D1F9C (project_id), INDEX IDX_91F26D60BAD26311 (tag_id), PRIMARY KEY(project_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `role` (id INT AUTO_INCREMENT NOT NULL, colors_id INT DEFAULT NULL, name VARCHAR(30) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_57698A6A5C002039 (colors_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `skill` (id INT AUTO_INCREMENT NOT NULL, colors_id INT DEFAULT NULL, name VARCHAR(30) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_5E3DE4775C002039 (colors_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `tag` (id INT AUTO_INCREMENT NOT NULL, colors_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_389B7835C002039 (colors_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `category` ADD CONSTRAINT FK_64C19C15C002039 FOREIGN KEY (colors_id) REFERENCES `color` (id)');
        $this->addSql('ALTER TABLE `color` ADD CONSTRAINT FK_665648E960E4B879 FOREIGN KEY (feature_id) REFERENCES `feature` (id)');
        $this->addSql('ALTER TABLE `experience` ADD CONSTRAINT FK_590C1035C002039 FOREIGN KEY (colors_id) REFERENCES `color` (id)');
        $this->addSql('ALTER TABLE experience_skill ADD CONSTRAINT FK_3D6F986146E90E27 FOREIGN KEY (experience_id) REFERENCES `experience` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience_skill ADD CONSTRAINT FK_3D6F98615585C142 FOREIGN KEY (skill_id) REFERENCES `skill` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `formation` ADD CONSTRAINT FK_404021BF5C002039 FOREIGN KEY (colors_id) REFERENCES `color` (id)');
        $this->addSql('ALTER TABLE formation_skill ADD CONSTRAINT FK_28B67A025200282E FOREIGN KEY (formation_id) REFERENCES `formation` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_skill ADD CONSTRAINT FK_28B67A025585C142 FOREIGN KEY (skill_id) REFERENCES `skill` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `project` ADD CONSTRAINT FK_2FB3D0EEA21214B7 FOREIGN KEY (categories_id) REFERENCES `category` (id)');
        $this->addSql('ALTER TABLE project_tag ADD CONSTRAINT FK_91F26D60166D1F9C FOREIGN KEY (project_id) REFERENCES `project` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_tag ADD CONSTRAINT FK_91F26D60BAD26311 FOREIGN KEY (tag_id) REFERENCES `tag` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `role` ADD CONSTRAINT FK_57698A6A5C002039 FOREIGN KEY (colors_id) REFERENCES `color` (id)');
        $this->addSql('ALTER TABLE `skill` ADD CONSTRAINT FK_5E3DE4775C002039 FOREIGN KEY (colors_id) REFERENCES `color` (id)');
        $this->addSql('ALTER TABLE `tag` ADD CONSTRAINT FK_389B7835C002039 FOREIGN KEY (colors_id) REFERENCES `color` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `category` DROP FOREIGN KEY FK_64C19C15C002039');
        $this->addSql('ALTER TABLE `color` DROP FOREIGN KEY FK_665648E960E4B879');
        $this->addSql('ALTER TABLE `experience` DROP FOREIGN KEY FK_590C1035C002039');
        $this->addSql('ALTER TABLE experience_skill DROP FOREIGN KEY FK_3D6F986146E90E27');
        $this->addSql('ALTER TABLE experience_skill DROP FOREIGN KEY FK_3D6F98615585C142');
        $this->addSql('ALTER TABLE `formation` DROP FOREIGN KEY FK_404021BF5C002039');
        $this->addSql('ALTER TABLE formation_skill DROP FOREIGN KEY FK_28B67A025200282E');
        $this->addSql('ALTER TABLE formation_skill DROP FOREIGN KEY FK_28B67A025585C142');
        $this->addSql('ALTER TABLE `project` DROP FOREIGN KEY FK_2FB3D0EEA21214B7');
        $this->addSql('ALTER TABLE project_tag DROP FOREIGN KEY FK_91F26D60166D1F9C');
        $this->addSql('ALTER TABLE project_tag DROP FOREIGN KEY FK_91F26D60BAD26311');
        $this->addSql('ALTER TABLE `role` DROP FOREIGN KEY FK_57698A6A5C002039');
        $this->addSql('ALTER TABLE `skill` DROP FOREIGN KEY FK_5E3DE4775C002039');
        $this->addSql('ALTER TABLE `tag` DROP FOREIGN KEY FK_389B7835C002039');
        $this->addSql('DROP TABLE `category`');
        $this->addSql('DROP TABLE `color`');
        $this->addSql('DROP TABLE `experience`');
        $this->addSql('DROP TABLE experience_skill');
        $this->addSql('DROP TABLE `feature`');
        $this->addSql('DROP TABLE `formation`');
        $this->addSql('DROP TABLE formation_skill');
        $this->addSql('DROP TABLE `menu`');
        $this->addSql('DROP TABLE `project`');
        $this->addSql('DROP TABLE project_tag');
        $this->addSql('DROP TABLE `role`');
        $this->addSql('DROP TABLE `skill`');
        $this->addSql('DROP TABLE `tag`');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
