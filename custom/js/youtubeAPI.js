/* 
   FIXME  
  issue: API 최초 호출시간이 너무 길다. 
  
  1. 최초에 $category selector가 잡히지 않아서 DOMContentLoaded를 썼는데 꼭 써야하는가?
  2. script load 시점을 변경하는 방법은 없는가?
  3. 서버단에서 미리 불러올수는 없는가?
*/

const youtube = function({selector, apiInfo}) {
  const $category = document.querySelector(selector)
  const BASE_URL = 'https://www.googleapis.com/youtube/v3/'
  const API_KEY = 'AIzaSyBLdmPtMrgF7vvDZArfx7i3Mdkli4B2KxA'

  const message = {
    NO_LISTS_DATA: '카테고리가 존재하지 않습니다.'
  }

  const create = async () => {
    const data = filterCategoryTitle(await getYoutubeData())
    render(data)
  }

  const createURL = (apiInfo) => {
    if (!apiInfo.type) {
      throw 'API 정보를 확인해주세요'
    }

    const { options } = apiInfo
    let url = `${BASE_URL + apiInfo.type}?key=${API_KEY}&`

    for (var value in options) {
      url += `${value}=${options[value]}&`
    }

    url = url.substr(0, url.length-1);
    return url
  }

  const getYoutubeData = async () => {
    const API_URL = createURL(apiInfo)
    const res = await axios(API_URL)
    const { data } = await res
    // console.log(data)
    return data
  }

  const filterCategoryTitle = (data = []) => {
    const { items } = data
    const titleLists = items.map(item => {
      const { snippet : { title } } = item
      return title
    })

    return titleLists
  }

  const render = (data = []) => {
    console.log('[YOUTUBE API] render()')
    $category.innerHTML = data.length ? createCategoryList(data) : message.NO_LISTS_DATA
  }

  const createCategoryList = (titleLists) => {
    return titleLists.reduce((html, title) => {
      return html += `<li>${title}</li>`
    }, '<ul>') + '</ul>'
  }

  const test = () => {
    console.log('외부에서 호출')
  }

  create()

  return {
    test
  }
}

document.addEventListener("DOMContentLoaded", function() {
  const api = new youtube({
      selector: '#videoCategories',
      apiInfo: {
        type: 'videoCategories',
        options: {
          regionCode: 'KR',
          part: 'snippet',
          hl: 'ko'
        }
      }
    }
  )
});