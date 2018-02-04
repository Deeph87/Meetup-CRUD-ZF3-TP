var casper = require('casper').create();
var URL = 'http://localhost:8080';
var wait = 2500;
var pageTitle = 'Liste des Meetups';
var title = 'Meetup PHP à Limoges';

casper.test.begin('Delete a meetup', 2, function suite(test) {
    casper.start(URL, function() {
        this.echo("I'm on the homepage with the list of meetups");
    });

    casper.thenClick('.btn-danger', function() {
        this.echo("I clicked on the button to delete a meetup");
        this.echo("Loading...");
        this.wait(wait, function() {
            this.echo("Complete !");
        });
    });

    casper.then(function(){
        this.echo("I'm redirect on the list of meetups page and we assert that the meetup were removed !");
        test.assertTextDoesntExist('<h2>' + title + '</h2>'); // Title of the meetup
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
