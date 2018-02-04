var casper = require('casper').create();
var URL = 'http://localhost:8080';
var wait = 2500;
var pageTitle = 'Liste des Meetups';
var title = 'Meetup PHP à Limoges';
var description = 'Venez rencontrer la communauté PHP à Ester Technopole les 17 et 18 Mars 2018 !';
var dateStart = '2018-02-17';
var dateEnd = '2018-02-18';

casper.test.begin('Add a meetup', 2, function suite(test) {
    casper.start(URL, function() {
        this.echo("I'm on the homepage with the list of meetups");
    });

    casper.thenClick('.btn-success', function() {
        this.echo("I clicked on the button to add a meetup");
        this.echo("Loading...");
        this.wait(wait, function() {
            this.echo("Complete !");
        });
    });

    casper.then(function(){
        this.fill('form#meetup', {
            'title' : title,
            'description' : description,
            'dateStart' : dateStart,
            'dateEnd' : dateEnd
        })
        this.echo("I populate the form");
    });

    casper.thenClick('.btn-primary', function(){
        this.echo("I clicked on the button to submit the form");
        this.echo("Loading...");
        this.wait(wait, function() {
            this.echo("Complete !");
        });
    });

    casper.then(function(){
        this.echo("I'm redirect on the list of meetups page and we assert that the meetup were added !");
        test.assertTextExist(title); // Title of the meetup
        test.assertTextExist(pageTitle); // Title of the page
    });

    casper.then(function(){
        this.echo('SlimerJS will close !');
        this.wait(wait, function() {
            casper.exit();
        });
    });

    casper.viewport(1024, 768);

    casper.run(function(){
        test.done();
    });
});
