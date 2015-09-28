do ->
  problem_notify = ->
    $('html').removeClass('uploading')
    $('html').removeClass('drag-hover')
    $('html').addClass('error')
    window.setTimeout(->
      $('html').removeClass('error')
      $('.uploader').show(100)
      $('.upload_notify').hide(100)
    , 2000)

    $('.error_notify').show(100).delay(2000).hide(100)

  upload_file = (file, signed_request, url) ->
    xhr = new XMLHttpRequest
    xhr.open 'PUT', signed_request

    xhr.onload = ->
      if xhr.status == 200
        $('.uploader').show(100)
        $('.upload_notify').hide(100)
        $('html').removeClass('drag-hover')
        $('html').removeClass('uploading')
        window.location = "http://s.shapetape.xyz/#{url}"

    xhr.onerror = ->
      problem_notify()

    xhr.send file

  sendFile = (file) ->
    $('html').removeClass('drag-hover')
    $('html').addClass('uploading')
    $('.uploader').hide(100)
    $('.upload_notify').show(100)
    $.get '/upload_request.php', {}, (data) ->
      if data.request?
        upload_file file, data.request, data.url
      else
        problem_notify()

  setup = ->
    dragMessage = $('.drag-message')
    description = $('.description')

    $('#file_upload_button').click ->
      sendFile $('#file_input').files[0]

    html = $('html')
    html.addClass('ready')
    html.on "dragover", ->
      html.addClass('drag-hover')
      dragMessage.addClass('drag-hover')
      description.addClass('drag-hover')
    html.on "dragleave", ->
      html.removeClass('drag-hover')
      dragMessage.removeClass('drag-hover')
      description.removeClass('drag-hover')
    window.addEventListener 'dragover', ((e) ->
      e = e or event
      e.preventDefault()
      return
    ), false
    window.addEventListener 'drop', ((e) ->
      e = e or event
      e.preventDefault()
      sendFile e.dataTransfer.files[0]
      return
    ), false

  $ ->
    setup()
