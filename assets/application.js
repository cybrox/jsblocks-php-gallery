var App = blocks.Application();

var Image = App.Model({
    name: App.Property(),

    active: blocks.observable(false),

    setImage: function(e) {
        window.location.hash = this.name();
        this.collection().forEach(function(img) {
            img.active(false);
        });
        this._application.Gallery.image(this.name());
        this.active(true);
    }
});

var Images = App.Collection(Image);


App.View('Gallery', {
    filterValue: blocks.observable(),
    image: blocks.observable("_missing.jpg"),
    index: blocks.observable(0),

    images: Images(window.__images).extend('filter', function (value) {
        var filter = this.filterValue();

        if (filter === undefined) return true;
        return value.name().toLowerCase().indexOf(filter.toLowerCase()) !== -1;
    }),

    openImage: function(e) {
        var url  = window.location.href.replace(window.location.hash, "");
            url += window.__imgdir.replace("./", "");
            url += '/'+this.image();

        window.open(url);
    },

    handleAction: function(e) {
        if (e.which == 37) {
            if (this.images()[this.index() - 1] == undefined) return;
            this.index(this.index() - 1);
            this.images()[this.index()].setImage();
            window.scrollBy(0, -27);
        }
        if (e.which == 39) {
            if (this.images()[this.index() + 1] == undefined) return;
            this.index(this.index() + 1);
            this.images()[this.index()].setImage();
            window.scrollBy(0, 27);
        }
    },

    init: function() {
        if (window.location.hash !== undefined) {
            var thisImg = window.location.hash.replace('#', '');
            this.images.push(Image({name: thisImg, active: true}));
            this.images.reverse();
            this.image(thisImg);
            return;
        }

        if (this.images()[0] !== undefined)
            this.images()[0].setImage();
    }
});
