var _ = require("underscore");
var UUID = require("uuid");
var moment = require("moment");
var gravatar = require("gravatar");

var Activity = function(activityType, actionText, options) {
  var defaults = {
    "email": "",
    "displayName": "",
    "image": {
        "url": "http://www.gravatar.com/avatar/00000000000000000000000000000000?d=wavatar&s=48",
        "width": 48,
        "height": 48
     }
  };

  // Override defaults
  this.options = _.defaults(options, defaults);
  
  this.type = activityType;
  this.id = UUID.v1();
  this.date = moment().format("ddd, DD MMM YYYY HH:mm:ss ZZ");
  
  this.actionText = actionText;
  this.displayName = this.options.displayName;
  this.image = this.options.image;
  
  if (this.options.get_gravatar && this.options.email) {
    this.image.url = gravatar.url(this.options["email"], {s: 80, d: "mm", r: "g"});
    
    if(!this.displayName) {
      var profile = gravatar.get_profile(gravatar.profile_url(this.options.email), function(error, profile) {
        if (profile.displayName) {
          this.displayName = profile.displayName;
        }
      });
    }
  }
  
  return this;
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