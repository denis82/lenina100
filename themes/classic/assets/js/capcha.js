	var reCaptcha1;
      var reCaptcha2;
      var myCallBack = function() {
        //Render the recaptcha1 on the element with ID "recaptcha1"
        reCaptcha1 = grecaptcha.render('reCaptcha1', {
          'sitekey' : '6LcdMhMUAAAAAKgxgM9XJNQdoz6eT-9yyhDICAao', //Replace this with your Site key
          'theme' : 'light'
        });
        
        //Render the recaptcha2 on the element with ID "recaptcha2"
        reCaptcha2 = grecaptcha.render('reCaptcha2', {
          'sitekey' : '6LccdRQUAAAAAFM6MuELMCgN0yu576TtzcMQhCYi', //Replace this with your Site key
          'theme' : 'dark'
        });
      };