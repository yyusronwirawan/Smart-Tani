var isModule = typeof module !== "undefined" && module.exports

if (isModule) {
    http = require('http')
    URL = require('url')
}

var Weather = {
    Utils: {}
}

Weather.VERSION = "0.1.0"
Weather.LANGUAGE = "en" // default language is English

var jsonp = Weather.Utils.jsonp = function (uri, callback) {
    return new Promise(function (resolve, reject) {
        var id = '_' + Math.round(10000 * Math.random())
        var callbackName = 'jsonp_callback_' + id
        var el = (document.getElementsByTagName('head')[0] || document.body || document.documentElement)
        var script = document.createElement('script')
        var src = uri + '&callback=' + callbackName

        window[callbackName] = function (data) {
            delete window[callbackName]
            var ele = document.getElementById(id)
            ele.parentNode.removeChild(ele)
            resolve(data)
        }

        script.src = src
        script.id = id
        script.addEventListener('error', reject)
        el.appendChild(script)
    })
}

Weather.getApiKey = function () {
    return Weather.APIKEY
}

Weather.setApiKey = function (apiKey) {
    Weather.APIKEY = apiKey
}

Weather.getLanguage = function () {
    return Weather.LANGUAGE
}

Weather.setLanguage = function (language) {
    Weather.LANGUAGE = language
}

Weather.kelvinToFahrenheit = function (value) {
    return (this.kelvinToCelsius(value) * 1.8) + 32
}

Weather.kelvinToCelsius = function (value) {
    return value - 273.15
}

Weather.getCurrent = function (city, callback) {
    var url = "https://api.openweathermap.org/data/2.5/weather?q=" + encodeURIComponent(city) + "&cnt=1"

    if (Weather.LANGUAGE) {
        url = url + "&lang=" + Weather.LANGUAGE
    }

    if (Weather.APIKEY) {
        url = url + "&APPID=" + Weather.APIKEY
    } else {
        console.log('WARNING: You must provide an OpenWeatherMap API key.')
    }

    return this._getJSON(url, function (data) {
        callback(new Weather.Current(data))
    })
}

Weather.getCurrentByCityId = function (cityId, callback) {
    var url = "https://api.openweathermap.org/data/2.5/weather?id=" + encodeURIComponent(cityId) + "&cnt=1"

    if (Weather.LANGUAGE) {
        url = url + "&lang=" + Weather.LANGUAGE
    }

    if (Weather.APIKEY) {
        url = url + "&APPID=" + Weather.APIKEY
    } else {
        console.log('WARNING: You must provide an OpenWeatherMap API key.')
    }

    return this._getJSON(url, function (data) {
        callback(new Weather.Current(data))
    })
}

Weather.getCurrentByLatLong = function (lat, long, callback) {
    var url = "https://api.openweathermap.org/data/2.5/weather?lat=" + encodeURIComponent(lat) + "&lon=" + encodeURIComponent(long) + "&cnt=1"

    if (Weather.LANGUAGE) {
        url = url + "&lang=" + Weather.LANGUAGE
    }

    if (Weather.APIKEY) {
        url = url + "&APPID=" + Weather.APIKEY
    } else {
        console.log('WARNING: You must provide an OpenWeatherMap API key.')
    }

    return this._getJSON(url, function (data) {
        callback(new Weather.Current(data))
    })
}

Weather.getForecast = function (city, callback) {
    var url = "https://api.openweathermap.org/data/2.5/forecast?q=" + encodeURIComponent(city) + "&cnt=1"

    if (Weather.LANGUAGE) {
        url = url + "&lang=" + Weather.LANGUAGE
    }

    if (Weather.APIKEY) {
        url = url + "&APPID=" + Weather.APIKEY
    } else {
        console.log('WARNING: You must provide an OpenWeatherMap API key.')
    }

    return this._getJSON(url, function (data) {
        callback(new Weather.Forecast(data))
    })
}

Weather.getForecastByCityId = function (cityId, callback) {
    var url = "https://api.openweathermap.org/data/2.5/forecast?id=" + encodeURIComponent(cityId) + "&cnt=1"

    if (Weather.LANGUAGE) {
        url = url + "&lang=" + Weather.LANGUAGE
    }

    if (Weather.APIKEY) {
        url = url + "&APPID=" + Weather.APIKEY
    } else {
        console.log('WARNING: You must provide an OpenWeatherMap API key.')
    }

    return this._getJSON(url, function (data) {
        callback(new Weather.Forecast(data))
    })
}

Weather.getForecastByLatLong = function (lat, long, callback) {
    var url = "https://api.openweathermap.org/data/2.5/forecast?lat=" + encodeURIComponent(lat) + "&lon=" + encodeURIComponent(long) + "&cnt=1"

    if (Weather.LANGUAGE) {
        url = url + "&lang=" + Weather.LANGUAGE
    }

    if (Weather.APIKEY) {
        url = url + "&APPID=" + Weather.APIKEY
    } else {
        console.log('WARNING: You must provide an OpenWeatherMap API key.')
    }

    return this._getJSON(url, function (data) {
        callback(new Weather.Forecast(data))
    })
}

Weather._getJSON = function (url, callback) {
    if (isModule) {
        return http.get(URL.parse(url), function (response) {
            return callback(response.body)
        })
    } else {
        jsonp(url).then(callback)
    }
}

var maxBy = Weather.Utils.maxBy = function (list, iterator) {
    var max
    var f = function (memo, d) {
        var val = iterator(d)

        if (memo === null || val > max) {
            max = val
            memo = d
        }

        return memo
    }

    return list.reduce(f, null)
}

var minBy = Weather.Utils.minBy = function (list, iterator) {
    var min
    var f = function (memo, d) {
        var val = iterator(d)

        if (memo === null || val < min) {
            min = val
            memo = d
        }

        return memo
    }

    return list.reduce(f, null)
}

var isOnDate = Weather.Utils.isOnDate = function (a, b) {
    var sameYear = a.getYear() === b.getYear()
    var sameMonth = a.getMonth() === b.getMonth()
    var sameDate = a.getDate() === b.getDate()

    return sameYear && sameMonth && sameDate
}

Weather.Forecast = function (data) {
    this.data = data
}

Weather.Forecast.prototype.startAt = function () {
    return new Date(minBy(this.data.list, function (d) {
        return d.dt
    }).dt * 1000)
}

Weather.Forecast.prototype.endAt = function () {
    return new Date(maxBy(this.data.list, function (d) {
        return d.dt
    }).dt * 1000)
}

Weather.Forecast.prototype.day = function (date) {
    return new Weather.Forecast(this._filter(date))
}

Weather.Forecast.prototype.low = function () {
    if (this.data.list.length === 0) return

    var output = minBy(this.data.list, function (item) {
        return item.main.temp_min
    })

    return output.main.temp_min
}

Weather.Forecast.prototype.high = function () {
    if (this.data.list.length === 0) return

    var output = maxBy(this.data.list, function (item) {
        return item.main.temp_max
    })

    return output.main.temp_max
}

Weather.Forecast.prototype._filter = function (date) {
    return {
        list: this.data.list.filter(function (range) {
            var dateTimestamp = (range.dt * 1000)

            if (isOnDate(new Date(dateTimestamp), date)) {
                return range
            }
        })
    }
}

Weather.Current = function (data) {
    this.data = data
}

Weather.Current.prototype.temperature = function () {
    return this.data.main.temp
}

Weather.Current.prototype.conditions = function () {
    return this.data.weather[0].description
}

Weather.Current.prototype.icon = function () {
    return this.data.weather[0].icon
}

Weather.Current.prototype.name = function() {
    return this.data.name
}

if (isModule) {
    module.exports = Weather
} else {
    window.Weather = Weather
}

// API Key methods
var apiKey = 'ca256a4d06d07884e0b86e5b4e816d73'
Weather.setApiKey(apiKey)

// Language methods
var langugage = "en" // set the language to German - libraries default language is "en" (English)
Weather.setLanguage(langugage)

// Get the current weather for a given city using the latitude and longitude
var $refresh = $('.weather-refresh')
var $loading = $('.weather-loading').hide()
var $weatherContainer = $('.weather-container').hide()

$refresh.on('click', function(){
    $weatherContainer.find('.weather-update-time').text('...')
    checkGeo(showWeather)
})

setInterval(checkGeo(showWeather), 60000)

checkGeo(showWeather)
$loading.show()

function showWeather(position) {
    Weather.getCurrentByLatLong(position.coords.latitude, position.coords.longitude, function (current) {
        var temperature = parseInt(Weather.kelvinToCelsius(current.temperature()))
        var conditions = current.conditions()
        var iconcode = current.icon()
        // console.log(conditions)
        var iconurl = "http://openweathermap.org/img/wn/" + iconcode + "@2x.png"
        var city = current.name()

        $weatherContainer.find('.city').text(city)
        $weatherContainer.find('img').attr('src', iconurl).attr('alt', conditions)
        $weatherContainer.find('.text-degree').text(temperature + '°')
        $weatherContainer.find('.conditions').text(conditions)
        $weatherContainer.find('.weather-update-time').text(moment().format('D MMM, HH:mm'))
        $weatherContainer.show()
        $loading.hide()
    })
}
