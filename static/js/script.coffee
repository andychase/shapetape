do ->
  problem_notify = ->
    $('html').removeClass('uploading')
    $('html').removeClass('drag-hover')
    $('.upload_notify').hide()
    $('.drag-message').removeClass('drag-hover')

    $('html').addClass('error')
    window.setTimeout(->
      $('html').removeClass('error')
      $('.description').removeClass('drag-hover')
      $('.uploader').show(100)
    , 2000)

    $('.error_notify').show(100).delay(2000).hide(1)

  upload_file = (file, signed_request_data) ->
    xhr = new XMLHttpRequest
    xhr.open 'POST', signed_request_data.url, true
    formData = new FormData()
    for key of signed_request_data.fields
      formData.append(key, signed_request_data.fields[key])
    formData.append('file', file)

    xhr.onload = ->
      if xhr.status == 204
        $('.uploader').show(100)
        $('.upload_notify').hide(100)
        $('html').removeClass('drag-hover')
        $('html').removeClass('uploading')
        window.location = signed_request_data.fields.key.split("/")[1].split(".")[0]

    xhr.onerror = ->
      problem_notify()

    xhr.send formData

  sendFile = (file) ->
    $('html').removeClass('drag-hover')
    $('.drag-message').removeClass('drag-hover')
    $('html').addClass('uploading')
    $('.uploader').hide(100)
    $('.upload_notify').show(100)
    $.get '/upload_request', {}, (data) ->
      if data.fields?
        upload_file file, data
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
