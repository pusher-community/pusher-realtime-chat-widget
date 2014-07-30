var _ = require("underscore");
var UUID = require("uuid");
var moment = require("moment");
var gravatar = require("gravatar");

var Activity = function(activityType, actionText, options, callback) {
  var self = this;
  
  var defaults = {
    "email": "",
    "displayName": "<em>Anon</em>",
    "image": {
        "url": "http://www.gravatar.com/avatar/00000000000000000000000000000000?d=wavatar&s=48",
        "width": 48,
        "height": 48
     }
  };

  // Override defaults
  self.options = _.defaults(options, defaults);
  
  self.type = activityType;
  self.id = UUID.v1();
  self.date = moment().format("ddd, DD MMM YYYY HH:mm:ss ZZ");
  
  self.actionText = actionText;
  self.displayName = self.options.displayName;
  self.image = self.options.image;
  
  if (self.options.get_gravatar && self.options.email) {
    self.image.url = gravatar.url(self.options["email"], {s: 80, d: "mm", r: "g"});
    
    var profile = gravatar.get_profile(gravatar.profile_url(self.options.email), function(error, profile) {
      if (profile.entry[0].displayName) {
        self.displayName = profile.entry[0].displayName;
      }

      callback(self);
    });
  } else {
    callback(self);
  }
};

Activity.prototype.getMessage = function() {
  var activity = {
    "id": this.id,
    "body": this.actionText,
    "published": this.date,
    "type": this.type,
    "actor": {
      "displayName": this.displayName,
      "objectType": "person",
      "image": this.image
    }
  };

  return activity;
};

exports = module.exports = Activity;