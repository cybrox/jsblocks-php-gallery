var App = blocks.Application();

var Images = App.Collection({

});


App.View('Gallery', {
    filterValue: blocks.observable(),

    images: Images(window.__images).extend('filter', function (value) {
        var filter = this.filterValue();

        if (filter === undefined) return true;
        return value.name().toLowerCase().indexOf(filter.toLowerCase()) !== -1;
    })
});
