Scrumban Bundle
===============

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Kalaxia/ScrumbanBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Kalaxia/ScrumbanBundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Kalaxia/ScrumbanBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Kalaxia/ScrumbanBundle/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Kalaxia/ScrumbanBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Kalaxia/ScrumbanBundle/build-status/master)

This Symfony bundle imports your Scrum project data into your application.

You can retrieve your epics and your user stories from Trello boards (soon Github, Gitlab, and other boards as well !) and then use it as you like !

For example, you can display on your website the roadmap of your project, or your current sprint work.

Installation
------------

You can use Composer to install the project:

```
composer require kalaxia/scrumban-bundle
```

Configuration
-------------

After enabling the bundle, you can configure it with the following YAML lines:

```
scrumban:
    trello:
        has_plus_for_trello: true # use PlusForTrello extension way to extract estimations data
        boards:
            kanban: # board name, use it as identifier for your scrumban commands
                id: 0DxDo8vl # the Trello ID of your board. You can configure it in an environment variable if you like
        columns: # Columns configuration override, more details below
            ready:
                name: 'sprint_ready'
                type: 'user_story'
                status: 'ready'
            review:
                name: 'to_validate'
                type: 'user_story'
                status: 'review'
            to_release:
                name: 'to_deploy'
                type: 'user_story'
                status: 'to_release'
```

Columns are mapped to associate their cards to a precise story type and status.

* The ``name`` field is the slug of your board column.
* The ``type`` for now can only be *user_story*. Later, epics, technical stories, bugs and feedbacks will be configurable
* The ``status`` can be one of the pre-configured statuses. See the ``Statuses`` section below.

This bundle comes with a default mapping, which you can rather extend or override.

The default mapping is:

```
ready:
    name: 'ready'
    type: 'user_story'
    status: 'ready'
todo:
    name: 'todo'
    type: 'user_story'
    status: 'todo'
in_progress:
    name: 'in_progress'
    type: 'user_story'
    status: 'in_progress'
review:
    name: 'review'
    type: 'user_story'
    status: 'review'
to_release:
    name: 'to_release'
    type: 'user_story'
    status: 'to_release'
done:
    name: 'done'
    type: 'user_story'
    status: 'done'
```

Synchronize with your board
---------------------------

You can use the following command with the configured board name to import your user stories:

```
./bin/console scrumban:trello:sync kanban
```

It will update the existing user stories in your database, and create the others.

Sprints
-------

This bundle allows you to create your sprints, with data such as begin and end dates, demonstration URL, and later more will certainly be added.

You can use the bundle command

```
./bin/console scrumban:sprint:create --begin 2018-10-10 --end 2018-10-09
```

Or directly implement the manager in your code:

```
// src/Controller/DefaultController.php

// ...
use Scrumban\Manager\SprintManager;

class DefaultController extends Controller
{
    public function createSprintAction(SprintManager $sprintManager, Request $request)
    {
        $beginDate = new \DateTime($request->request->get('begin_date'));
        $endDate = new \DateTime($request->request->get('end_date'));

        $sprint = $sprintManager->createSprint($beginDate, $endDate);
    }
}
```

Sprints will conflict if they have dates in common. An exception will be thrown in this case.

When you synchronize your board, the cards in columns associated to certain statuses will be associated to the current sprint if you have created sprints.

The default statuses are:

* todo
* in_progress
* review
* to_release

For now, this is not overridable, but it will be in the future.

Contributions
-------------

Do not hesitate to open issues if you have any questions, feedbacks, ideas, or if you encounter some bugs with the bundle.

It is rather new for the moment so it's obviously not perfect, and contributions are very welcome :-) !

Unleash the might of open-source community :D !