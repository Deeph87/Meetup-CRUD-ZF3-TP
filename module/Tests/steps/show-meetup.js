var casper = require('casper').create();
var URL = 'http://localhost:8080';
var wait = 2500;
var title = 'Meetup PHP à Limoges';

casper.test.begin('Show a meetup', 2, function suite(test) {
    casper.start(URL, function() {
        this.echo("I'm on the homepage with the list of meetups");
    });

    casper.thenClick('.btn-primary', function() {
        this.echo("I clicked on the button to show a meetup");
        this.echo("Loading...");
        this.wait(wait, function() {
            this.echo("Complete !");
        });
    });

    casper.then(function(){
        this.echo("I'm on the detailed page of the meetup selected !");
        test.assertTextExist(title); // Title of the meetup
        test.assertTextDoesntExist('<h1>'); // Title of the page
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
