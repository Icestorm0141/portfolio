
-- --------------------------------------------------
-- Entity Designer DDL Script for SQL Server 2005, 2008, 2012 and Azure
-- --------------------------------------------------
-- Date Created: 08/03/2015 18:46:14
-- Generated from EDMX file: C:\Users\Anna\Google Drive\WebPortfolio\Portfolio.Library\DBLibrary.edmx
-- --------------------------------------------------

SET QUOTED_IDENTIFIER OFF;
GO
USE [web_portfolio];
GO
IF SCHEMA_ID(N'dbo') IS NULL EXECUTE(N'CREATE SCHEMA [dbo]');
GO

-- --------------------------------------------------
-- Dropping existing FOREIGN KEY constraints
-- --------------------------------------------------


-- --------------------------------------------------
-- Dropping existing tables
-- --------------------------------------------------

IF OBJECT_ID(N'[dbo].[BlogPosts]', 'U') IS NOT NULL
    DROP TABLE [dbo].[BlogPosts];
GO

-- --------------------------------------------------
-- Creating all tables
-- --------------------------------------------------

-- Creating table 'BlogPosts'
CREATE TABLE [dbo].[BlogPosts] (
    [PostId] int IDENTITY(1,1) NOT NULL,
    [Title] varchar(100)  NOT NULL,
    [DatePublished] datetime  NOT NULL,
    [PostContent] varchar(max)  NOT NULL
);
GO

-- Creating table 'Projects'
CREATE TABLE [dbo].[Projects] (
    [ProjectId] int IDENTITY(1,1) NOT NULL,
    [Title] nvarchar(max)  NOT NULL,
    [Date] datetime  NOT NULL,
    [SoftwareUsed] nvarchar(max)  NOT NULL,
    [Description] nvarchar(max)  NOT NULL,
    [ImageName] nvarchar(max)  NOT NULL,
    [WebUrl] nvarchar(max)  NOT NULL,
    [Category_CategoryId] int  NOT NULL
);
GO

-- Creating table 'Categories'
CREATE TABLE [dbo].[Categories] (
    [CategoryId] int IDENTITY(1,1) NOT NULL,
    [Name] nvarchar(max)  NOT NULL
);
GO

-- --------------------------------------------------
-- Creating all PRIMARY KEY constraints
-- --------------------------------------------------

-- Creating primary key on [PostId] in table 'BlogPosts'
ALTER TABLE [dbo].[BlogPosts]
ADD CONSTRAINT [PK_BlogPosts]
    PRIMARY KEY CLUSTERED ([PostId] ASC);
GO

-- Creating primary key on [ProjectId] in table 'Projects'
ALTER TABLE [dbo].[Projects]
ADD CONSTRAINT [PK_Projects]
    PRIMARY KEY CLUSTERED ([ProjectId] ASC);
GO

-- Creating primary key on [CategoryId] in table 'Categories'
ALTER TABLE [dbo].[Categories]
ADD CONSTRAINT [PK_Categories]
    PRIMARY KEY CLUSTERED ([CategoryId] ASC);
GO

-- --------------------------------------------------
-- Creating all FOREIGN KEY constraints
-- --------------------------------------------------

-- Creating foreign key on [Category_CategoryId] in table 'Projects'
ALTER TABLE [dbo].[Projects]
ADD CONSTRAINT [FK_ProjectCategories]
    FOREIGN KEY ([Category_CategoryId])
    REFERENCES [dbo].[Categories]
        ([CategoryId])
    ON DELETE NO ACTION ON UPDATE NO ACTION;

-- Creating non-clustered index for FOREIGN KEY 'FK_ProjectCategories'
CREATE INDEX [IX_FK_ProjectCategories]
ON [dbo].[Projects]
    ([Category_CategoryId]);
GO

-- --------------------------------------------------
-- Script has ended
-- --------------------------------------------------