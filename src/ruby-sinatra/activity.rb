require 'digest/md5'
require 'uuid'

class Activity
  
  def initialize(activity_type, action_text, options)
    
    @options = set_default_options(options)
      
    @type = activity_type
    @id = UUID.new.generate
    @date = Time.now.to_s()
    
    @action_text = action_text;
    @display_name = options["displayName"]
    @image = options['image'];
    
    if( options['get_gravatar'] &&
        options['email'] )
         
      @image["url"] = get_gravatar(options['email'])
      
    end
    
  end
  
  def getMessage() 
    activity = {
      'id' => @id,
      'body' => @action_text,
      'published' => @date,
      'type' => @type,
      'actor' => {
        'displayName' => @display_name,
        'objectType' => 'person',
        'image' => @image
      }
    }
    return activity
  end
  
  def set_default_options(options)
    defaults = {
      'email' => nil,
      'displayName' => nil,
      'image' => {
          'url' => 'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=wavatar&s=48',
          'width' => 48,
          'height' => 48
       }
    }
    
    defaults.each {
      |key, value|
      if( !options[key] )
        options[key] = value
      end
    }
    
    return options
  end
  
  # from: http://en.gravatar.com/site/implement/images/php/
  # 
  # Get either a Gravatar URL or complete image tag for a specified email address.
  # 
  # @param string $email The email address
  # @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
  # @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
  # @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
  # @return String containing either just a URL or a complete image tag
  # @source http://gravatar.com/site/implement/images/php/
  # 
  def get_gravatar( email, s = 80, d = 'mm', r = 'g' ) 
  	# get the email from URL-parameters or what have you and make lowercase
    email_address = email.downcase

    # create the md5 hash
    hash = Digest::MD5.hexdigest(email_address)
    
    url = 'http://www.gravatar.com/avatar/'
  	url += hash
  	url += "?s=" + s.to_s() 
  	url += "&d=" + d
  	url += "&r=" + r
  	
  	return url
  end
  
end