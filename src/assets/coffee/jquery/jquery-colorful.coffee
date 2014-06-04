# Reference jQuery
$ = jQuery

# Adds plugin object to jQuery
$.fn.extend
  colorful: (options) ->
    # Default settings
    settings =
      colors: [
        [62,  35,  255]
        [60,  255, 60 ]
        [255, 35,  98 ]
        [45,  175, 230]
        [255, 0,   255]
        [255, 128, 0  ]
      ]
      gradientSpeed: 0.002
      debug: false

    # Merge default settings with options.
    settings = $.extend settings, options

    # Private members
    step = 0

    # color table indices for:
    #   current color left
    #   next color left
    #   current color right
    #   next color right
    colorIndices = [0, 1, 2, 3]

    # Target element
    target = $('<div/>')

    # Simple logger.
    log = (msg) ->
      console?.log msg if settings.debug

    # Callback / handler for updating the background gradient
    updateGradient = () ->
      c0_0 = settings.colors[ colorIndices[0] ]
      c0_1 = settings.colors[ colorIndices[1] ]
      c1_0 = settings.colors[ colorIndices[2] ]
      c1_1 = settings.colors[ colorIndices[3] ]

      istep = 1 - step;

      # Calculate new colors
      r1 = Math.round(istep * c0_0[0] + step * c0_1[0])
      g1 = Math.round(istep * c0_0[1] + step * c0_1[1])
      b1 = Math.round(istep * c0_0[2] + step * c0_1[2])
      color1 = "#"+((r1 << 16) | (g1 << 8) | b1).toString(16)

      r2 = Math.round(istep * c1_0[0] + step * c1_1[0])
      g2 = Math.round(istep * c1_0[1] + step * c1_1[1])
      b2 = Math.round(istep * c1_0[2] + step * c1_1[2])
      color2 = "#"+((r2 << 16) | (g2 << 8) | b2).toString(16)

      # Apply the new style to the element
      target.css
        background: "-webkit-gradient(linear, left top, right top, from("+color1+"), to("+color2+"))"

      target.css
        background: "-moz-linear-gradient(left, "+color1+" 0%, "+color2+" 100%)"

      # Next step
      step += settings.gradientSpeed

      # Reset if necessary
      if step >= 1
        step %= 1
        colorIndices[0] = colorIndices[1]
        colorIndices[2] = colorIndices[3]

        # pick two new target color indices
        # do not pick the same as the current one
        colorIndices[1] = ( colorIndices[1] + Math.floor( 1 + Math.random() * (settings.colors.length - 1))) % settings.colors.length
        colorIndices[3] = ( colorIndices[3] + Math.floor( 1 + Math.random() * (settings.colors.length - 1))) % settings.colors.length


    # Apply colorful background to all elements
    target = this
    setInterval updateGradient, 100