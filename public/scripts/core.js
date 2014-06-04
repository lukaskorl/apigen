(function() {
  var $;

  $ = jQuery;

  $.fn.extend({
    colorful: function(options) {
      var colorIndices, log, settings, step, target, updateGradient;
      settings = {
        colors: [[62, 35, 255], [60, 255, 60], [255, 35, 98], [45, 175, 230], [255, 0, 255], [255, 128, 0]],
        gradientSpeed: 0.002,
        debug: false
      };
      settings = $.extend(settings, options);
      step = 0;
      colorIndices = [0, 1, 2, 3];
      target = $('<div/>');
      log = function(msg) {
        if (settings.debug) {
          return typeof console !== "undefined" && console !== null ? console.log(msg) : void 0;
        }
      };
      updateGradient = function() {
        var b1, b2, c0_0, c0_1, c1_0, c1_1, color1, color2, g1, g2, istep, r1, r2;
        c0_0 = settings.colors[colorIndices[0]];
        c0_1 = settings.colors[colorIndices[1]];
        c1_0 = settings.colors[colorIndices[2]];
        c1_1 = settings.colors[colorIndices[3]];
        istep = 1 - step;
        r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
        g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
        b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
        color1 = "#" + ((r1 << 16) | (g1 << 8) | b1).toString(16);
        r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
        g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
        b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
        color2 = "#" + ((r2 << 16) | (g2 << 8) | b2).toString(16);
        target.css({
          background: "-webkit-gradient(linear, left top, right top, from(" + color1 + "), to(" + color2 + "))"
        });
        target.css({
          background: "-moz-linear-gradient(left, " + color1 + " 0%, " + color2 + " 100%)"
        });
        step += settings.gradientSpeed;
        if (step >= 1) {
          step %= 1;
          colorIndices[0] = colorIndices[1];
          colorIndices[2] = colorIndices[3];
          colorIndices[1] = (colorIndices[1] + Math.floor(1 + Math.random() * (settings.colors.length - 1))) % settings.colors.length;
          return colorIndices[3] = (colorIndices[3] + Math.floor(1 + Math.random() * (settings.colors.length - 1))) % settings.colors.length;
        }
      };
      target = this;
      return setInterval(updateGradient, 100);
    }
  });

}).call(this);
