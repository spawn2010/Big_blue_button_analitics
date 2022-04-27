import { Application } from "@hotwired/stimulus"
import { definitionsFromContext } from "@hotwired/stimulus-webpack-helpers"


window.Stimulus = Application.start()
const context = require.context("../../src/js/controllers", true, /\.js$/)
Stimulus.load(definitionsFromContext(context))
