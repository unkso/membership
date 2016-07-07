if (!WCF.UnkSo) {
    WCF.UnkSo = {};
}

WCF.UnkSo.Award = {};

WCF.UnkSo.Award.Preview = WCF.Popover.extend({
    /**
     * action proxy
     * @var	WCF.Action.Proxy
     */
    _proxy: null,

    /**
     * @see	WCF.Popover.init()
     */
    init: function() {
        this._super('.wbbAwardLink, .wbbIssuedAwardLink');

        // init proxy
        this._proxy = new WCF.Action.Proxy({
            showLoadingOverlay: false
        });

        WCF.DOMNodeInsertedHandler.addCallback('WBB.UnkSo.Award.Preview', $.proxy(this._initContainers, this));
    },

    /**
     * @see	WCF.Popover._loadContent()
     */
    _loadContent: function() {
        var $link = $('#' + this._activeElementID);

        if ($link.hasClass('wbbAwardLink')) {
            this._proxy.setOption('data', {
                actionName: 'getAwardPreview',
                className: 'wcf\\data\\award\\AwardAction',
                objectIDs: [ $link.data('awardID') ]
            });
        } else {
            this._proxy.setOption('data', {
                actionName: 'getIssuedAwardPreview',
                className: 'wcf\\data\\award\\AwardAction',
                objectIDs: [ $link.data('awardID') ]
            });
        }

        var $elementID = this._activeElementID;
        var self = this;
        this._proxy.setOption('success', function(data, textStatus, jqXHR) {
            self._insertContent($elementID, data.returnValues.template, true);
        });
        this._proxy.setOption('failure', function(data, jqXHR, textStatus, errorThrown) {
            self._insertContent($elementID, data.message, true);

            return false;
        });
        this._proxy.sendRequest();
    }
});