(wp => {
  let el = wp.element.createElement
  let components = wp.components
  let blockControls = wp.editor.BlockControls
  let inspectorControls = wp.editor.InspectorControls
  let data = wpTrafftLabels.data
  let labels = wpTrafftLabels.labels
  let __ = wp.i18n.__
  let iconEl = el('svg', {width: '20', height: '20', viewBox: '0 0 20 20'},
      el('path', {
        style: { fill: '#5ABCFF' },
        d: 'M10 5C11.3807 5 12.5 3.88071 12.5 2.5C12.5 1.11929 11.3807 0 10 0C8.61929 0 7.5 1.11929 7.5 2.5C7.5 3.88071 8.61929 5 10 5Z'
      }),
      el('path', {
        style: { fill: '#5ABCFF' },
        d: 'M17.5 5C18.8807 5 20 3.88071 20 2.5C20 1.11929 18.8807 0 17.5 0C16.1193 0 15 1.11929 15 2.5C15 3.88071 16.1193 5 17.5 5Z'
      }),
      el('path', {
        style: { fill: '#5ABCFF' },
        d: 'M10 20C11.3807 20 12.5 18.8807 12.5 17.5C12.5 16.1193 11.3807 15 10 15C8.61929 15 7.5 16.1193 7.5 17.5C7.5 18.8807 8.61929 20 10 20Z'
      }),
      el('path', {
        style: { fill: 'url(#paint0_linear_11484_27047)' },
        d: 'M17.5 15C17.3672 15 17.2344 15.0156 17.1094 15.0312C15.3828 15.3047 12.8906 13.0703 12.5 11.1797V8.75C12.5 8.0625 11.9375 7.5 11.25 7.5H8.82031C7.20312 7.16406 5.33594 5.29688 5 3.67969V0H0V5H3.67969C5.29688 5.33594 7.16406 7.20312 7.5 8.82031V11.25C7.5 11.9375 8.0625 12.5 8.75 12.5H11.1797C13.0703 12.8906 15.3047 15.3828 15.0312 17.1094C15.0078 17.2344 15 17.3672 15 17.5C15 19.0469 16.3984 20.2656 18 19.9531C18.9766 19.7656 19.7578 18.9766 19.9531 18C20.2656 16.3984 19.0469 15 17.5 15Z'
      }),
      el('defs', null, el('linearGradient',
          { id: 'paint0_linear_11484_27047', x1: '0', 'y1': 10, 'x2': 20.0004, 'y2': '10', 'gradientUnits': 'userSpaceOnUse'},
          el('stop', { stopColor: '#5ABCFF' }),
          el('stop', { offset: '0.8997', stopColor: '#005AEE' })
      )),
  )

  const blockStyle = {
    color: 'red'
  }
  const categories = []
  const services = []
  const employees = []
  const locations = []
  const languages = []

  if (data.categories.length !== 0) {
    for (let i = 0; i < data.categories.length; i++) {
      categories.push({
        value: data.categories[i].id,
        text: data.categories[i].name + ' (id: ' + data.categories[i].id + ')'
      })
    }
  }

  if (data.services.length !== 0) {
    // Create array of services objects
    for (let i = 0; i < data.services.length; i++) {
      if (data.services[i].length !== 0) {
        services.push({
          value: data.services[i].id,
          text: data.services[i].name + ' (id: ' + data.services[i].id + ')'
        })
      }
    }
  }

  if (data.employees.length !== 0) {
    // Create array of employees objects
    for (let i = 0; i < data.employees.length; i++) {
      employees.push({
        value: data.employees[i].slug,
        text: data.employees[i].firstName + ' ' + data.employees[i].lastName + ' (id: ' + data.employees[i].id + ')'
      })
    }
  }

  if (data.locations.length !== 0) {
    // Create array of locations objects
    for (let i = 0; i < data.locations.length; i++) {
      locations.push({
        value: data.locations[i].id,
        text: data.locations[i].name + ' (id: ' + data.locations[i].id + ')'
      })
    }
  }

  if (data.languages.length !== 0) {
    // Create array of locations objects
    for (let i = 0; i < data.languages.length; i++) {
      languages.push({
        value: data.languages[i].code,
        text: data.languages[i].label
      })
    }
  }

  wp.blocks.registerBlockType( 'trafft/booking-gutenberg-block', {
          title: __('Trafft Booking', 'trafft'),
          description: __('Trafft Booking enables your customers to effortlessly schedule appointments with just a few clicks. Utilize templates or adjust the step order to align the booking flow with your specific use case.', 'trafft'),
          icon: iconEl,
          category: 'embed',
          attributes: {
            short_code: {
              type: 'string',
              default: '[trafftbooking]'
            },
            location: {
              type: 'string',
              default: ''
            },
            category: {
              type: 'string',
              default: ''
            },
            service: {
              type: 'string',
              default: ''
            },
            employee: {
              type: 'string',
              default: ''
            },
            minHeight: {
              type: 'string',
              default: '500',
            },
            language: {
              type: 'string',
              default: '',
            },
            parameters: {
              type: 'boolean',
              default: false
            }
          },
          edit: function (props) {
            var inspectorElements = []
            var attributes = props.attributes
            var options = []

            options['categories'] = [{value: '', label: labels.show_all_categories}]
            options['services'] = [{value: '', label: labels.show_all_services}]
            options['employees'] = [{value: '', label: labels.show_all_employees}]
            options['locations'] = [{value: '', label: labels.show_all_locations}]
            options['languages'] = [{value: '', label: labels.default_language}]

            function getOptions(data) {
              var options = []

              data = Object.keys(data).map(function (key) {
                return data[key]
              })

              data.sort(function (a, b) {
                if (parseInt(a.pos) < parseInt(b.pos)) return -1
                if (parseInt(a.pos) > parseInt(b.pos)) return 1
                return 0
              })

              data.forEach(function (element) {
                options.push({value: element.value, label: element.text})
              })

              return options
            }

            getOptions(categories)
              .forEach(function (element) {
                options['categories'].push(element)
              })

            getOptions(services)
              .forEach(function (element) {
                options['services'].push(element)
              })

            getOptions(employees)
              .forEach(function (element) {
                options['employees'].push(element)
              })

            if (locations.length) {
              getOptions(locations)
                .forEach(function (element) {
                  options['locations'].push(element)
                })
            }

            getOptions(languages)
              .forEach(function (element) {
                options['languages'].push(element)
              })

            function getShortCode(props, attributes) {
              var shortCode = ''

              if (categories.length !== 0 && services.length !== 0 && employees.length !== 0) {
                shortCode = '[trafftbooking'

                if (attributes.service) {
                  shortCode += ' service=' + attributes.service + ''
                } else if (attributes.category) {
                  shortCode += ' category=' + attributes.category + ''
                }

                if (attributes.employee) {
                  shortCode += ' employee=' + attributes.employee + ''
                } else if (attributes.location) {
                  shortCode += ' location=' + attributes.location + ''
                }

                shortCode += ' min-height=' + (attributes.minHeight ? attributes.minHeight : '500') + ''

                if (attributes.language) {
                  shortCode += ' language=' + attributes.language + ''
                }

                shortCode += ']'
              } else {
                shortCode = labels.no_entities_notice
              }

              props.setAttributes({short_code: shortCode})

              return shortCode
            }

            inspectorElements.push(el(components.Panel,
              {},
              el('label', {htmlFor: 'trafft-min-height', style: { paddingBottom: '8px' }}, labels.min_height),
              el(components.TextControl, {
                id: 'trafft-min-height',
                value: attributes.minHeight,
                onChange: function (e) {
                  return props.setAttributes({minHeight: e.replace(/\D/g, "")})
                },
              })
            ))

            inspectorElements.push(el(components.SelectControl, {
              id: 'trafft-js-select-language',
              label: wpTrafftLabels.default_language,
              value: attributes.language,
              options: options.languages,
              onChange: function (selectControl) {
                return props.setAttributes({language: selectControl})
              }
            }))

            if (categories.length !== 0 && services.length !== 0 && employees.length !== 0) {

              inspectorElements.push(el(components.PanelRow,
                {},
                el('label', {htmlFor: 'trafft-js-parameters'}, labels.preselect_booking_parameters),
                el(components.FormToggle, {
                  id: 'trafft-js-parameters',
                  checked: attributes.parameters,
                  onChange: function () {
                    return props.setAttributes({parameters: !props.attributes.parameters})
                  },
                })
              ))

              inspectorElements.push(el('div', {style: {'margin-bottom': '1em'}}, ''))

              if (attributes.parameters) {
                inspectorElements.push(el(components.SelectControl, {
                  id: 'trafft-js-select-category',
                  label: wpTrafftLabels.select_category,
                  value: attributes.category,
                  options: options.categories,
                  onChange: function (selectControl) {
                    return props.setAttributes({category: selectControl})
                  }
                }))

                inspectorElements.push(el('div', {style: {'margin-bottom': '1em'}}, ''))

                inspectorElements.push(el(components.SelectControl, {
                  id: 'trafft-js-select-service',
                  label: wpTrafftLabels.select_service,
                  value: attributes.service,
                  options: options.services,
                  onChange: function (selectControl) {
                    return props.setAttributes({service: selectControl})
                  }
                }))

                inspectorElements.push(el('div', {style: {'margin-bottom': '1em'}}, ''))

                inspectorElements.push(el(components.SelectControl, {
                  id: 'trafft-js-select-employee',
                  label: wpTrafftLabels.select_employee,
                  value: attributes.employee,
                  options: options.employees,
                  onChange: function (selectControl) {
                    return props.setAttributes({employee: selectControl})
                  }
                }))

                inspectorElements.push(el('div', {style: {'margin-bottom': '1em'}}, ''))

                inspectorElements.push(el(components.SelectControl, {
                  id: 'trafft-js-select-location',
                  label: wpTrafftLabels.select_location,
                  value: attributes.location,
                  options: options.locations,
                  onChange: function (selectControl) {
                    return props.setAttributes({location: selectControl})
                  }
                }))
              }

              return [
                el(blockControls, { key: 'controls' }),
                el(inspectorControls, { key: 'inspector' },
                  el(components.PanelBody, {initialOpen: true},
                    inspectorElements
                  )
                ),
                el('div', {},
                  getShortCode(props, props.attributes)
                )
              ]

            }
          },
          save: function (props) {
              return (
                  el('div', {},
                      props.attributes.short_code
                  )
              )
          }
      }
  )
})(window.wp)