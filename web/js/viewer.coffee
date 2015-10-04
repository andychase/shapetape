$ ->
  img_container = $('#img-container')
  vector = $('#vector')
  placeholder = $('#placeholder')
  $('#vector, #placeholder, .small-logo').on 'dragstart', (event) ->
    event.preventDefault()

  toggleImg = ->
    placeholder.show()
    vector.hide()
  toggleVec = ->
    placeholder.hide()
    vector.show()
  toggleVec()


  slideValue = 90
  zooming = false
  $('.slider').on 'input', ->
    if not zooming
      toggleImg()
      zooming = true
    slideValue = this.value
    img_container.css('width', slideValue + "%")
    if slideValue <= 71
      img_container.css('width', "auto")

  $('.slider').on 'mouseup', ->
    if zooming
      toggleVec()
      zooming = false
    return true

  curYPos = 0
  curXPos = 0
  curDown = false
  window.addEventListener 'mousemove', (e) ->
    if not zooming and curDown
      window.scrollTo document.body.scrollLeft + curXPos - (e.pageX), document.body.scrollTop + curYPos - (e.pageY)
    return true
  window.addEventListener 'mousedown', (e) ->
    if not zooming and e.clientY > 65
      curDown = true
      curYPos = e.pageY
      curXPos = e.pageX
    return true
  window.addEventListener 'mouseup', (e) ->
    curDown = false
    return true
