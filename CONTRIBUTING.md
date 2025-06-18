# Contributing to OCR-P15

First off, thanks for taking the time to contribute! ❤️

All types of contributions are encouraged and valued. See the [Table of Contents](#table-of-contents) for different ways to help and details about how this project handles them. Please make sure to read the relevant section before making your contribution. It will make it a lot easier for us maintainers and smooth out the experience for all involved. The community looks forward to your contributions. 🎉

## Table of Contents

- [I Have a Question](#i-have-a-question)
- [I Want To Contribute](#i-want-to-contribute)
    - [Reporting Bugs](#reporting-bugs)
    - [Suggesting Enhancements](#suggesting-enhancements)
    - [Your First Code Contribution](#your-first-code-contribution)
    - [Improving The Documentation](#improving-the-documentation)
- [Styleguides](#styleguides)
    - [Commit Messages](#commit-messages)
- [Join The Project Team](#join-the-project-team)

## I Have a Question

> If you want to ask a question, we assume that you have read the available [Documentation](README.md).

Before you ask a question, it is best to search for existing [Issues](https://github.com/LucasSch1/OCR-P15.git/issues) that might help you. In case you have found a suitable issue and still need clarification, you can write your question in this issue. It is also advisable to search the internet for answers first.

If you then still feel the need to ask a question and need clarification, we recommend the following:

- Open an [Issue](https://github.com/LucasSch1/OCR-P15.git/issues/new).
- Provide as much context as you can about what you're running into.
- Provide your environment details:
    - PHP Version
    - Symfony Version
    - Database Type and Version
    - OS and Version

## I Want To Contribute

### Legal Notice
When contributing to this project, you must agree that you have authored 100% of the content, that you have the necessary rights to the content and that the content you contribute may be provided under the project licence.

### Reporting Bugs

#### Before Submitting a Bug Report

A good bug report shouldn't leave others needing to chase you up for more information. Therefore, we ask you to investigate carefully, collect information and describe the issue in detail in your report. Please complete the following steps in advance to help us fix any potential bug as fast as possible.

- Make sure that you are using the latest version.
- Determine if your bug is really a bug and not an error on your side e.g. using incompatible environment components/versions.
- Check if there is not already a bug report existing for your bug in the [bug tracker](https://github.com/LucasSch1/OCR-P15.git/issues?q=label%3Abug).
- Collect information about the bug:
    - Stack trace
    - OS, Platform and Version
    - PHP Version
    - Symfony Version
    - Database Type and Version
    - Steps to reproduce
    - Expected behavior
    - Actual behavior

#### How Do I Submit a Good Bug Report?

> You must never report security related issues, vulnerabilities or bugs including sensitive information to the issue tracker, or elsewhere in public. Instead sensitive bugs must be sent by email to <security-p15@example.com>.

We use GitHub issues to track bugs and errors. If you run into an issue with the project:

- Open an [Issue](https://github.com/LucasSch1/OCR-P15.git/issues/new).
- Explain the behavior you would expect and the actual behavior.
- Please provide as much context as possible and describe the *reproduction steps*.
- Include any relevant code snippets or error messages.

### Suggesting Enhancements

This section guides you through submitting an enhancement suggestion for OCR-P15, including completely new features and minor improvements to existing functionality.

#### Before Submitting an Enhancement

- Make sure that you are using the latest version.
- Read the [documentation](README.md) carefully.
- Perform a [search](https://github.com/LucasSch1/OCR-P15.git/issues) to see if the enhancement has already been suggested.
- Consider if your enhancement aligns with the project's goals and would benefit the majority of users.

#### How Do I Submit a Good Enhancement Suggestion?

- Use a **clear and descriptive title** for the issue.
- Provide a **step-by-step description** of the suggested enhancement.
- **Describe the current behavior** and **explain which behavior you expected to see instead**.
- **Explain why this enhancement would be useful** to most OCR-P15 users.

### Your First Code Contribution

1. **Setup Development Environment**
   ```bash
   # Clone the repository
   git clone https://github.com/LucasSch1/OCR-P15.git
   cd OCR-P15

   # Install dependencies
   composer install

   # Setup database
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate

   # Setup test database
   php bin/console doctrine:database:create --env=test
   php bin/console doctrine:migrations:migrate --env=test
   php bin/console doctrine:fixtures:load --env=test
   ```

2. **Development Workflow**
    - Create a new branch for your feature/fix
    - Make your changes
      Run PHP CS Fixer to ensure code style consistency:
      ```bash
      # Check code style without making changes
      vendor/bin/php-cs-fixer fix --dry-run
      
      # Fix code style issues automatically
      vendor/bin/php-cs-fixer fix
      ````
    - Run tests: `php bin/phpunit`
    - Run static analysis: `vendor/bin/phpstan analyse`
    - Submit a Pull Request

### Improving The Documentation

- Update the README.md with new features or changes
- Add PHPDoc comments to new code
- Update API documentation if applicable
- Add examples for new features

## Styleguides

### Commit Messages
- Use present tense ("Add feature" not "Added feature")
- Use imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit the first line to 72 characters or less
- Reference issues and pull requests liberally after the first line

## Join The Project Team

To join the project team:
1. Make several quality contributions
2. Show commitment to the project
3. Follow the code of conduct
4. Contact the project maintainers

## Attribution
This guide is based on the [contributing.md](https://contributing.md/generator) template, adapted for OCR-P15.
