/*
    Original Source Code GitHub URL: https://github.com/ljacqu/mathtrainer
    This JS is to support the Game... Math Trainer for Speed training and practice of mathematics.
    Modified extensively by Dean Stanley-Hunt 08/2018
    -Added second timer for question answering time limits, then shows correct answer when time is up!
    -Added Numpad for touchscreen support
    -Added addition option to customize the seconds per question to answer it
    -Removed skip question support since plater can find the answer when question time runs out
    -Added Wipeouts count to count how many times the player failed to answer before question time was up.
    -Added Jquery Ajax request running through MVC to record trainer scores for logged in users when game sessions end.
*/

(function () {
  'use strict';

  /**
   * List of supported operators.
   */
  var operators = {
    add: {name: 'add', sign: '+',    result: function (a, b) { return a + b; }},
    sub: {name: 'sub', sign: '-',    result: function (a, b) { return a - b; }},
    mul: {name: 'mul', sign: '\xD7', result: function (a, b) { return a * b; }},
    div: {name: 'div', sign: '\xF7', result: function (a, b) { return a / b; }}
  };

  /**
   * Configuration parameters provided by the user.
   *  min: The smallest number to use in the questions.
   *  max: The largest number to use in the questions.
   *  minutes: The number of minutes the trainer should run for.
   *  avoidNegatives: If true, guarantees that subtraction results are never 
   *     negative. Only takes effect if min >= 0.
   *  operators: The operators to use in the questions.
   */
  var config = {
    min: 0,
    max: 0,
    minutes: 5,
    seconds: 12,
    saved: 0,
    avoidNegatives: true,
    operators: ['add', 'div']
  };

  /**
   * Statistics of the current run.
   */
  var stats = {
    total: 0,
    failed: 0,
    timeout: 0
  };

  /**
   * Data of the current question the trainer is showing.
   */
  var question = {
    a: 0,
    b: 0,
    result: 0,
    sign: '+'
  };

  /** Trainer logic. */
  var trainer = {};

  /**
   * Functions for the current trainer question.
   */
  trainer.question = function () {
    /**
     * Returns a random integer between min and max.
     * @param {Number} min lower bound
     * @param {Number} max upper bound
     * @returns {Number} Random int in [min, max]
     */
    var randomInt = function (min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    };

    /**
     * Returns a random operator the user wants to use.
     * @returns {operators}
     */
    var getRandomOperator = function () {
      return operators[
        config.operators[randomInt(0, config.operators.length - 1)]
      ];
    };
      
    /**
     * Shows the answer.
     * Question time has run out so a failure to answer in time is recorded
     * Question timer has stopped
     */
    var showAnswer = function () {
      if (stats.timeout == 0)
      {
           stats.timeout = 1;
           $('#question_math').text(question.a + '\xA0' + question.sign + '\xA0' +
             question.b + " = " + question.result);
           ++stats.failed;  
      }
    };
      
    /** The end question timer functionality. Added by Dean SH 2018 */
    var timer = function () {
      /**
       * Formats the total elapsed time of the counter if it was stopped
       * prematurely, e.g. if config.minutes = 5, we return "1:15" if the timer
       * shows "3:45".
       * @param {Object} event Event emitted by the timer upon cancellation
       * @returns {String} The elapsed time as string
       */

      /**
       * Starts the timer and sets up the stopped/finished event.
       */
      var start = function () {
        $('#timer_q').countdown(new Date().getTime() + config.seconds * 1000)
        .on('update.countdown', function (event) {
          $(this).text(event.strftime('%M:%S'));
        })
        // sic: the event is mistyped
        .on('stoped.countdown', function (event) {
          $(this).text('00:00');
        })
        .on('finish.countdown', function () {
          $(this).text('00:00');
          showAnswer();
        });
      };

      return {
        start: start
      };
    }();
    
        /**
     * Updates the HTML document with the data from the question.
     * @param {String} sign The sign symbol of the operator used in the question
     */
    var updateQuestionText = function (sign) {
      $('#result').val('');
      $('#question_math').text(question.a + '\xA0' + sign + '\xA0' + question.b);
      $('#questions_correct').text(stats.total - stats.failed);
      $('#questions_failed').text(stats.failed);
      $('#questions_total').text(stats.total);
      timer.start();
    };

    /**
     * Creates a new question (updates the variables accordingly).
     */
    var createNew = function () {
      var a = randomInt(config.min, config.max);
      var b = randomInt(config.min, config.max);

      var operator = getRandomOperator();
      if (operator.name === 'sub' && config.avoidNegatives) {
        // Ensure that a <= b when config.avoidNegatives is true
        var ab = a > b ? [b, a] : [a, b];
        a = ab[1];
        b = ab[0];
        question.result = a - b;
      } else if (operator.name === 'div') {
        var mulResult = a * b;
        question.result = a;
        a = mulResult;
      } else {
        question.result = operator.result(a, b);
      }
      question.a = a;
      question.b = b;
      question.sign = operator.sign;
      stats.timeout = 0;
      updateQuestionText(operator.sign);
    };

    /**
     * Checks whether the input answer is correct and creates a new one if this
     * is the case.
     */
    var verifyAndContinue = function (prUserResult) { 
      var userResult = parseInt($('#result').val());
      if (!prUserResult == null) {
          userResult = parseInt(prUserResult);
      }
      if (!isNaN(userResult) && userResult === question.result) {
        ++stats.total;
        $('#timer_q').countdown('stop');
        createNew();
      }
    };
      
    return {
      createNew: createNew,
      verifyAndContinue: verifyAndContinue
    };
  }();

  /**
   * Initializer of the options based on user input.
   */
  trainer.options = function () {

    /**
     * Error functionality.
     */
    var error = function () {
      /** Keeps track if at least one error was added to avoid a DOM lookup. */
      var errorAdded = false;
      /**
       * Displays an error message about a configuration.
       * @param {String} id The ID of the field/checkbox the error is about
       * @param {String} message The message to output
       */
      var add = function (id, message) {
        errorAdded = true;
        $('#options_error').append(message + '<br />');
        $('#' + id).addClass('optionerror');
      };
      /**
       * Returns whether an error was added since reset() was last called.
       * @returns {Boolean} True if there is at least one error, false otherwise
       */
      var hasErrors = function () {
        return errorAdded;
      };
      /**
       * Removes all errors and error classes.
       */
      var reset = function () {
        $('#options_error').text('');
        $('.optionerror').removeClass('optionerror');
        errorAdded = false;
      };

      return {
        add: add,
        hasErrors: hasErrors,
        reset: reset
      };
    }();

    /**
     * Sets the min and max config parameters, ensuring that min is not greater
     * than max.
     * @param {Number} min The minimum number to use (or max)
     * @param {Number} max The maximum number to use (or min)
     */
    var registerMinAndMaxValues = function (min, max) {
      if (min > max) {
        var tmp = max;
        max = min;
        min = tmp;
        $('#min').val(min);
        $('#max').val(max);
      }
      config.min = min;
      config.max = max;
    };

    /**
     * Processes the minimum and maximum option fields.
     */
    var initializeMinAndMax = function () {
      var min = parseInt($('#min').val());
      var max = parseInt($('#max').val());
      if (isNaN(min)) {
        error.add('min', 'The min field must be a number');
      } else if (isNaN(max)) {
        error.add('max', 'The max field must be a number');
      } else {
        registerMinAndMaxValues(min, max);
      }
    };

    /**
     * Processes timer minutes field.
     */
    var initializeMinutes = function () {
      var timerValue = parseInt($('#timer_length').val());
      if (isNaN(timerValue)) {
        error.add('timer_length', 'Please enter a valid number of minutes');
      } else if (timerValue <= 0) {
        error.add('timer_length', 'Please enter a positive number of minutes');
      } else {
        config.minutes = timerValue;
      }
    };
      
    /**
     * Processes per question timer minutes field. (Added By Dean SH 2018)
     */
    var initializeSeconds = function () {
      var timerValue = parseInt($('#timer_q_length').val());
      if (isNaN(timerValue)) {
        error.add('timer_q_length', 'Please enter a valid number of minutes');
      } else if (timerValue <= 0) {
        error.add('timer_q_length', 'Please enter a positive number of minutes');
      } else {
        config.seconds = timerValue;
      }
    };

    /**
     * Processes the operators the user wants to use for the training session.
     * Note that the checkboxes in the HTML are expected to have ID #op_{name},
     * where {name} is the operator abbreviation, e.g. #op_add or #op_div.
     */
    var initializeOperators = function () {
      var inputOperators = [];
      for (var key in operators) {
        if (operators.hasOwnProperty(key)) {
          if ($('#op_' + key).is(':checked')) {
            inputOperators.push(key);
          }
        }
      }
      if (inputOperators.length === 0) {
        error.add('op_wrapper', 'Please select at least one operator!');
      } else {
        config.operators = inputOperators;
      }
    };

    /**
     * Processes the checkbox to avoid negative results for subtraction.
     */
    var initializeAvoidNegatives = function () {
      if (config.min >= 0) {
        config.avoidNegatives = $('#avoid_negative').is(':checked');
      } else {
        config.avoidNegatives = false;
      }
    };

    /**
     * Initializes the user options.
     * @returns {Boolean} True if all options are valid and the trainer can be
     *  started, false if there is an error in the input options.
     */
    var initialize = function () {
      error.reset();
      initializeMinutes();  
      initializeSeconds();
      initializeMinAndMax();
      initializeOperators();
      if (error.hasErrors()) {
        $('#error_wrapper').show();
        return false;
      }
      $('#error_wrapper').hide();
      initializeAvoidNegatives();
      return true;
    };

    return {
      initialize: initialize
    };
  }();

  /**
   * Initializer and timer functionality.
   */
  trainer.run = function () {
    /**
     * Sets the score time when the timer has stopped or has been canceled.
     * @param {?String} timeString Optional string to use as time display if the
     *  timer was canceled
     */
    var setScoreText = function (timeString) {
      if (timeString) {
        $('#score_time').text(timeString);
      } else {
        $('#score_time').text(config.minutes + ' minute' +
          (config.minutes !== 1 ? 's' : ''));
      }
      $('#score_question_time').text(config.seconds);
      $('#score_failed').text(stats.failed);
      $('#score_total').text(stats.total - stats.failed);
    };
    
    // Jquery Ajax to store players score into DB - Added by Dean Stanley-Hunt
    var savePlayerScore = function () {
        if (config.saved == 0){
            config.saved = 1;
            var lcScore = "total="+(stats.total-stats.failed)+"&timeouts="+stats.failed+"&mins="+config.minutes+"&secs="+config.seconds;
            $.ajax({
                type: 'POST',
                url: '?cmd=score',
                data: lcScore,
                dataType: "text",
                success: function( resp ) {
                  //alert(resp);
                }
            });
        }
    }
    
    /**
     * Shows the score.
     * @param {?String} timeString Optional string to use as time display if the
     *  timer was canceled
     */
    var showScore = function (timeString) {
      setScoreText(timeString);
      savePlayerScore();
      $('#user').fadeOut(50, function () {
        $('#question').fadeOut(function () {
          $('#score, #options').fadeIn();
        });
      });
    };
      
    /** The end trainer timer functionality. */
    var timer = function () {
      /**
       * Formats the total elapsed time of the counter if it was stopped
       * prematurely, e.g. if config.minutes = 5, we return "1:15" if the timer
       * shows "3:45".
       * @param {Object} event Event emitted by the timer upon cancellation
       * @returns {String} The elapsed time as string
       */
      var computeElapsedTime = function (event) {
        if (event.offset.seconds === 0) {
          return (config.minutes - event.offset.minutes) + ':00';
        }
        var remainingSeconds = 60 - event.offset.seconds;
        return (config.minutes - event.offset.minutes - 1) + ':' +
          (remainingSeconds < 10 ? '0' : '') + remainingSeconds;
      };

      /**
       * Starts the timer and sets up the stopped/finished event.
       */
      var start = function () {
        $('#timer').countdown(new Date().getTime() + config.minutes * 60000)
        .on('update.countdown', function (event) {
          $(this).text(event.strftime('%M:%S'));
        })
        // sic: the event is mistyped
        .on('stoped.countdown', function (event) {
          showScore(computeElapsedTime(event));
        })
        .on('finish.countdown', function () {
          showScore();
        });
      };

      return {
        start: start
      };
    }();

      
    /**
     * Initializes the start of the trainer and transitions to the trainer view.
     */
    var initializeTrainer = function () {
      $('#options').fadeOut(function () {
        $('#question, #user').fadeIn();
      });
      $('#score').fadeOut();
      stats.total = 0;
      stats.failed = 0;
      stats.timeout = 0;
      config.saved = 0;
      $('#questions_correct').text('0');
      $('#questions_failed').text('0');
      $('#questions_total').text('0');
      timer.start();
    };

    return {
      initializeTrainer: initializeTrainer
    };
  }();

  /* ***********
   * Set event handlers once the document is ready
   * *********** */
  $(document).ready(function () {
    $('#result').keyup(function (e) {
      if (e.which === 32) {
        //$('#timer_q').countdown('stop'); // removed skip support ( Dean SH 2018 )
        //trainer.question.skip();
      } else {
        trainer.question.verifyAndContinue(null);
      }
    });

    $('#start').click(function () {
      var hasValidOptions = trainer.options.initialize();
      if (hasValidOptions) {
        trainer.question.createNew();
        trainer.run.initializeTrainer();
      }
    });

    $('#quit_to_options').click(function () {
      $('#timer').countdown('stop');
      $('#timer_q').countdown('stop');
    });
     
    $('#hide_numpad').click(function () {
      var userResult = $('#hide_numpad').val();
      if (userResult == 'Hide the Numpad')
      {
        $('#hide_numpad').val('Show the Numpad');   
        $('#touch_numpad').fadeOut();
      }
      else
      {
        $('#hide_numpad').val('Hide the Numpad'); 
        $('#touch_numpad').fadeIn();
      }
    });
      
    $('#numpad_1').click(function () {
      var userResult = $('#result').val() + '1';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });

    $('#numpad_2').click(function () {
      var userResult = $('#result').val() + '2';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });
      
    $('#numpad_3').click(function () {
      var userResult = $('#result').val() + '3';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });
      
    $('#numpad_4').click(function () {
      var userResult = $('#result').val() + '4';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });
      
    $('#numpad_5').click(function () {
      var userResult = $('#result').val() + '5';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });
      
    $('#numpad_6').click(function () {
      var userResult = $('#result').val() + '6';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });
      
    $('#numpad_7').click(function () {
      var userResult = $('#result').val() + '7';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });
      
    $('#numpad_8').click(function () {
      var userResult = $('#result').val() + '8';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });
      
    $('#numpad_9').click(function () {
      var userResult = $('#result').val() + '9';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });
      
    $('#numpad_0').click(function () {
      var userResult = $('#result').val() + '0';
      $('#result').val(userResult);
      trainer.question.verifyAndContinue(parseInt(userResult));
    });
      
    $('#numpad_del').click(function () {
      $('#result').val('');
    });
      
    $('#numpad_neg').click(function () {
      $('#result').val('-');
    });
      
    $('#start').fadeIn();
  });
})();
