var App = blocks.Application();

var Image = App.Model({
    name: App.Property(),

    active: blocks.observable(false),

    setImage: function(event) {
        window.location.hash = this.name();
        this.collection().forEach(function(img) {
            img.active(false);
        });
        this._application.Gallery.image(this.name());
        this.active(true);
        console.log(this.collection());
    }
});

var Images = App.Collection(Image);


App.View('Gallery', {
    filterValue: blocks.observable(),
    image: blocks.observable(),

    images: Images(window.__images).extend('filter', function (value) {
        var filter = this.filterValue();

        if (filter === undefined) return true;
        return value.name().toLowerCase().indexOf(filter.toLowerCase()) !== -1;
    }),

    init: function() {
        this.images()[0].setImage();
    }
});