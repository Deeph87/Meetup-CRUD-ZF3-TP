var casper = require('casper').create();
var URL = 'http://localhost:8080';
var wait = 2500;
var pageTitle = 'Liste des Meetups';
// var title = 'Meetup PHP à Limoges';
var description = 'Venez rencontrer la communauté PHP à Ester Technopole les 24 et 25 Mars 2018 !';
var dateStart = '2018-02-24';
var dateEnd = '2018-02-25';
var dateStartAssert = '24/02/2018';
var dateEndAssert = '25/02/2018';

casper.test.begin('Edit a meetup', 4, function suite(test) {
    casper.start(URL, function() {
        this.echo("I'm on the homepage with the list of meetups");
    });

    casper.thenClick('.btn-warning', function() {
        this.echo("I clicked on the button to edit a meetup");
        this.echo("Loading...");
        this.wait(wait, function() {
            this.echo("Complete !");
        });
    });

    casper.then(function(){
        this.fill('form#meetup', {
            'description' : description,
            'dateStart' : dateStart,
            'dateEnd' : dateEnd
        });
        this.echo("I populate the form with edited values");
    });

    casper.thenClick('.btn-primary', function(){
        this.echo("I clicked on the button to submit the form");
        this.echo("Loading...");
        this.wait(wait, function() {
            this.echo("Complete !");
        });
    });

    casper.then(function(){
        this.echo("I'm redirect on the list of meetups page and we assert that the meetup were edited !");
        test.assertTextExist(description); // New title of the meetup
        test.assertTextExist(dateStartAssert); // Date start of the meetup
        test.assertTextExist(dateEndAssert); // Date end of the meetup
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
