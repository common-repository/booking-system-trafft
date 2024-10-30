/* eslint-disable */
(function () {
  

  tinymce.create('tinymce.plugins.trafftBookingPlugin', {

    init: function (editor) {
      let labels = {};
      let win = null

      let entities = null
      let categories = null
      let services = null
      let employees = null
      let locations = null
      let languages = null

      let setAndOpenEditor = function () {
        editor.windowManager.close()

        let viewBody = []

        let filterItems = null

        // Filter
        filterItems = [
          {
            type: 'listbox',
            name: 'tr_booking_category',
            label: labels.select_category,
            classes: 'tr-booking-categories',
            values: [{
              value: 0,
              text: labels.show_all_categories
            }].concat(categories),
          },
          {
            type: 'listbox',
            name: 'tr_booking_service',
            label: labels.select_service,
            classes: 'tr-booking-services',
            values: [{
              value: 0,
              text: labels.show_all_services
            }].concat(services),
          },
          {
            type: 'listbox',
            name: 'tr_booking_employee',
            label: labels.select_employee,
            classes: 'tr-booking-employees',
            values: [{
              value: 0,
              text: labels.show_all_employees
            }].concat(employees),
          },
        ]

        if (locations.length) {
          filterItems.push({
            type: 'listbox',
            name: 'tr_booking_location',
            label: labels.select_location,
            classes: 'tr-booking-locations',
            values: [{
              value: 0,
              text: labels.show_all_locations
            }].concat(locations),
          })
        }

        viewBody.push({
          type: 'textbox',
          name: 'tr_booking_min_height',
          label: labels.min_height,
          classes: 'tr-booking-filter',
          value: 500,
          onInput: function (e) {
            e.target.value = e.target.value.replace(/\D/g, "")
          }
        })

        viewBody.push({
          type: 'listbox',
          name: 'tr_booking_language',
          label: labels.select_language,
          classes: 'tr-booking-languages',
          values: [{
            value: '',
            text: labels.default_language
          }].concat(languages),
        })

        viewBody.push({
          type: 'checkbox',
          name: 'tr_booking_filter',
          label: labels.preselect_booking_parameters,
          classes: 'tr-booking-filter',
          onChange: function () {
            let filterForm = win.find('#tr_booking_panel')
            filterForm.visible(!filterForm.visible())
          }
        })

        viewBody.push({
          type: 'form',
          name: 'tr_booking_panel',
          classes: 'tr-booking-panel',
          items: filterItems,
          visible: false,
        })

        // open editor
        win = editor.windowManager.open({
          title: 'Trafft Booking',
          width: 500,
          height: 435,
          body: viewBody,
          onSubmit: function (e) {
            let shortCodeString = ''

            if (e.data.tr_booking_service) {
              shortCodeString += ' service=' + e.data.tr_booking_service
            } else if (e.data.tr_booking_category) {
              shortCodeString += ' category=' + e.data.tr_booking_category
            }

            if (e.data.tr_booking_employee) {
              shortCodeString += ' employee=' + e.data.tr_booking_employee
            }

            if (e.data.tr_booking_location) {
              shortCodeString += ' location=' + e.data.tr_booking_location
            }

            if (e.data.tr_booking_min_height) {
              shortCodeString += ' min-height=' + e.data.tr_booking_min_height
            }

            if (e.data.tr_booking_language) {
              shortCodeString += ' language=' + e.data.tr_booking_language
            }

            editor.insertContent('[trafftbooking' + shortCodeString + ']')
          },

          onOpen: function () {
            categoryElement = win.find('#tr_category')
            serviceElement = win.find('#tr_service')

            categoryElement.visible(false)
            serviceElement.visible(false)
          },
        })
      }

      // Add new button
      editor.addButton('trafftButton', {
        title: 'Trafft Booking',
        cmd: 'trafftButtonCommand',
        image: trafft_plugin.url + 'src/assets/static/img/logo-symbol.svg'
      })

      // Button functionality
      editor.addCommand('trafftButtonCommand', function () {
        jQuery.ajax({
          url: trafft_plugin.ajax_url + '?action=get_entities',
          dataType: 'json',
          success: function (response) {
            labels = response.labels
            entities = response.data
            categories = []
            services = []
            employees = []
            locations = []
            languages = []

            for (let i = 0; i < entities.categories.length; i++) {
              categories.push({
                value: entities.categories[i].id,
                text: entities.categories[i].name + ' (id: ' + entities.categories[i].id + ')'
              })
            }

            for (let i = 0; i < entities.services.length; i++) {
              services.push({
                value: entities.services[i].id,
                text: entities.services[i].name + ' (id: ' + entities.services[i].id + ')'
              })
            }

            // Create array of employees objects
            for (let i = 0; i < entities.employees.length; i++) {
              employees.push({
                value: entities.employees[i].slug,
                text: entities.employees[i].firstName + ' ' + entities.employees[i].lastName + ' (id: ' + entities.employees[i].id + ')'
              })
            }

            // Create array of locations objects
            for (let i = 0; i < entities.locations.length; i++) {
              locations.push({
                value: entities.locations[i].id,
                text: entities.locations[i].name + ' (id: ' + entities.locations[i].id + ')'
              })
            }

            // Create array of languages objects
            for (let i = 0; i < entities.languages.length; i++) {
              languages.push({
                value: entities.languages[i].code,
                text: entities.languages[i].label
              })
            }

            // set and open editor
            setAndOpenEditor()
          }
        })
      })
    }
  })

  tinymce.PluginManager.add('trafftBookingPlugin', tinymce.plugins.trafftBookingPlugin)
})()
