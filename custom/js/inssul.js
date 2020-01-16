const common = (function() {
  const _setup = (el, parent) => {
    if (!parent) {
      selector = document.querySelector(el)
      if(!selector) throw `${el}가 존재하지 않습니다.`
    } else {
      selector = parent.querySelector(el)
      if(!selector) throw `${el}가 존재하지 않습니다.`
    }
    return selector
  }

  return {
    _setup
  }
})()



/*
  경로: page/creator_join_step3.php
  인스턴스 생성코드: const creatorJoin = new FileUpload({
            selector: '#upload_dashboard',
            preview: '#upload_preview'
        })
*/
const FileUpload = function (param) {
  const $uploadBtn = common._setup(param.selector)
  const $previewArea = common._setup(param.preview)

  const create = () => {
    addEvent()
  }

  const addEvent = () => {
    $previewArea.addEventListener("dragenter", dragenter);
    $previewArea.addEventListener("dragover", dragover);
    $previewArea.addEventListener("drop", drop);
    $uploadBtn.addEventListener('change', handleFiles)
  }

  function handleFiles(files) { 


    const fileList = files.length ? files : $uploadBtn.files

    // 읽기
    const reader = new FileReader();
    reader.readAsDataURL(fileList[0]); 

    //로드 한 후
    reader.onload = function  () {

        //썸네일 이미지 생성
        const tempImage = new Image(); //drawImage 메서드에 넣기 위해 이미지 객체화
        tempImage.src = reader.result; //data-uri를 이미지 객체에 주입
        tempImage.onload = function() {

          //리사이즈를 위해 캔버스 객체 생성
          const canvas = document.createElement('canvas');
          const canvasContext = canvas.getContext("2d");
            
          //캔버스 크기 설정
          canvas.width = $previewArea.offsetWidth; //가로 100px
          canvas.height = $previewArea.offsetHeight; //세로 100px

          //이미지를 캔버스에 그리기
          canvasContext.drawImage(this, 0, 0, $previewArea.offsetWidth, $previewArea.offsetHeight);
        
          //썸네일 이미지 보여주기
          $previewArea.style.padding = '0px'

          if($previewArea.children[1]) {
            $previewArea.children[1].remove()
          }

          $previewArea.appendChild(canvas)

        };
    }; 
}; 

  function dragenter(e) {
    e.stopPropagation();
    e.preventDefault();
  }
  
  function dragover(e) {
    e.stopPropagation();
    e.preventDefault();
  } 

  function drop(e) {
    e.stopPropagation();
    e.preventDefault();

    const dt = e.dataTransfer;
    const files = dt.files;
  
    handleFiles(files);
  }

  create()
}

/*
  경로: page/creator_join_step3.php
  인스턴스 생성코드: const addUploader = new AddUpload({
    addBtn: '#ep_add_btn',
    wrapper: '.extra_proof_wrap'
})
*/

// [FIXME] 업로드 양식 배열데이터를 기반으로 컨트롤 할수 있는 방안 모색할것.
const AddUpload = function(param) {
  const $addBtn = common._setup(param.addBtn)
  const $wrapper = common._setup(param.wrapper)
  const initUploader = document.querySelectorAll('.extra_proof_box .i_control')
  const $cancelBtn = document.querySelectorAll('.cancel_img_btn')
  let extraUploaders = []

  const create = () => {
    addEvent()
  }

  const addEvent = () => {
    $addBtn.addEventListener('click', handleAddUploader)
    
    Array.from($cancelBtn).forEach((btn) => {
      btn.addEventListener('click', _handleCancleImg)
    })

    // [FIXME] HTML 구조가 바뀔시 이벤트 적용이 틀어질수 있음 -> 더 나은 방법 찾기
    extraUploaders = Array.from(initUploader).map((uploader) => {
      const inputID = uploader.children[1].id
      const labelID = uploader.children[0].id

      return new FileUpload({
        selector: `#${inputID}`, 
        preview: `#${labelID}`
      })
    })
  }

  const replaceAttr = () => {
    const extraBoxs = document.querySelectorAll('.extra_proof_box')
    Array.from(extraBoxs).forEach((box, i) => {
      const input = box.querySelector('input')
      const label = box.querySelector('label')
      input.id = `extra_file_${i}`
      label.id = `upload_preview_${i}`
      label.setAttribute('for',`extra_file_${i}`)
    })
  }

  const _handleCancleImg = (e) => {
    const extraBoxs = document.querySelectorAll('.extra_proof_box')
    const label = e.currentTarget.parentNode
    const input = label.nextElementSibling
    const img = label.children[1] 
    const template = document.createElement('template')
    template.innerHTML = `<span style="font-size: 18px">+<br>Upload</span>`
    const plusBtn = template.content

    if (label.id === 'upload_preview' && img.tagName !== "SPAN") {
        img.remove()
        input.value = null
        label.appendChild(plusBtn)
    }

    if (label.id !== 'upload_preview') {
      if (extraBoxs.length <= 1) {
        alert('업로드 양식을 더이상 삭제할 수 없습니다.')
        return
      }

      if (img) {
        img.remove()
        input.value = null
      } else {
        const extraBox = e.currentTarget.parentNode.parentNode.parentNode
        extraBox.remove()
        replaceAttr()
      }
    }
  }

  const handleAddUploader = () => {
    const newUploader = getUploader()
    const limit = getLastUploader() + 1
    if (limit > 10) {
      alert('업로드 양식을 10개 이상 추가 할 수 없습니다.')
      return
    }
    $wrapper.appendChild(newUploader)

    // 새로운 업로드 양식 생성
    new FileUpload({
        selector: `#extra_file_${getLastUploader()}`, 
        preview: `#upload_preview_${getLastUploader()}`
    })

    const newSelector = `#upload_preview_${getLastUploader()}`
    const nowUploader = document.querySelector(newSelector)
    const newCancelBtn = nowUploader.querySelector('.cancel_img_btn')
    newCancelBtn.addEventListener('click', _handleCancleImg)
  }

  const getLastUploader = () => {
    return document.querySelectorAll('.extra_proof_box').length - 1
  }

  const getUploader = () => {
    const template = document.createElement('template')
    const html = `<div class="extra_proof_box">
                          <div class="i_control">
                              <label id="upload_preview_${getLastUploader() + 1}" for="extra_file_${getLastUploader() + 1}"><button type="button" class="cancel_img_btn"><i class='icon-cancel-circle'></i></button></label>
                              <input type="file" name="extra[]" id="extra_file_${getLastUploader() + 1}">
                              <input type="hidden" name="extra_delete_${getLastUploader() + 1}" id="extra_delete_${getLastUploader() + 1}" class="extra_delete" value="false"/>
                          </div>
                      </div>`
    template.innerHTML = html
    return template.content
  }
  
  create()

  return {
    _handleCancleImg
  }
}

/*
  경로: skin/member/inssul/register_form.skin.php
  인스턴스 생성코드: const emailCreator = EmailForm() 
*/
const EmailForm = function() {
  const emailFormArea = common._setup('.form_item_email')
  const emailId = common._setup('.email_id', emailFormArea)
  const emailSite = common._setup('.email_site', emailFormArea)
  const emailSelector = common._setup('.email_site_selector', emailFormArea)
  const emailData = common._setup('#reg_mb_email', emailFormArea)

  const create = () => {
    addEvent()
  }

  const addEvent = () => {
    emailId.addEventListener('keyup', handleEmailId)
    emailSelector.addEventListener('change', handleEmailSelector)
    emailId.addEventListener('focusout', emailValueChange)
    emailSelector.addEventListener('focusout', emailValueChange)
  }

  const handleEmailId = () => {
    return emailId.value
  }

  const handleEmailSelector = () => {
    if (emailSelector.value !== '직접입력') {
      emailSite.setAttribute('readonly', true)
      emailSite.value = emailSelector.value
    } else {
      emailSite.removeAttribute('readonly')
      emailSite.value = ''
      emailSite.focus()
    }

    return emailSite.value
  }

  const combineEmail = () => {
    if (handleEmailId() && handleEmailSelector()) {
      return handleEmailId()+'@'+handleEmailSelector()
    }
  }

  const emailValueChange = () => {
    emailData.value = combineEmail()
  }

  create()
}

/*
  경로: 
  인스턴스 생성코드: 
*/
const CertifyEmail = function() {

  const userEmailAddr = common._setup('.uesr_email_address').innerText
  const $checkBtn = common._setup('.auth_email')
  const URL = {
    naver: 'https://nid.naver.com/nidlogin.login?url=http%3A%2F%2Fmail.naver.com%2F',
    daum: 'https://logins.daum.net/accounts/signinform.do?url=http%3A%2F%2Fmail.daum.net%2F',
    gmail: 'https://accounts.google.com/ServiceLogin/signinchooser?service=mail&passive=true&rm=false&continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&ss=1&scc=1&ltmpl=default&ltmplcache=2&emr=1&osid=1&flowName=GlifWebSignIn&flowEntry=ServiceLogin'
  }

  const create = () => {
    changeHref()
  }

  const getCertifyUrl = () => {
    const emailAfterAt = userEmailAddr.split('@')
    const site = emailAfterAt[1].split('.')[0]
    let emailUrl = URL[site]
    
    if (!emailUrl) {
      emailUrl = 'http://www.' + emailAfterAt[1]
    }

    return emailUrl
  }

  const changeHref = () => {
    $checkBtn.setAttribute('href', getCertifyUrl())
  }

  create()
}

const WriterPage = function() {

  const wrapper = common._setup('.write-wrap')
  const $payPostBtn = wrapper.querySelectorAll('.pay_post_btn')
  const $payPostSelect = wrapper.querySelector('#pay_post_definition')
  const $payPostHidden = wrapper.querySelector('#payPostValue')

  const create = () => {
    addEvent()
  }

  const addEvent = () => {
    $payPostSelect.addEventListener('change', handleChangeSelector)
    Array.from($payPostBtn).forEach(btn => {
      btn.addEventListener('click', handleActivePostBtn)
    })
  }

  const handleActivePostBtn = (e) => {
    const currentBtn = e.currentTarget
    Array.from($payPostBtn).forEach(btn => {
      btn.classList.remove('active')
    })
    currentBtn.classList.add('active')

    handleChangeValue(currentBtn)
  }

  const handleChangeSelector = () => {
    $payPostHidden.value = $payPostSelect.value
  }

  const handleChangeValue = (btn) => {
    $payPostHidden.value = btn.value
  }

  create()
}

/*
  경로: board/inssul-board-creator/write/write.skin.php
  인스턴스 생성코드: const emailCreator = EmailForm() 
*/
const Counter = function(param) {

  const $counter = common._setup(param.selector)
  const $plusBtn = common._setup('.plus', $counter)
  const $minusBtn = common._setup('.minus', $counter)
  const $quantity = common._setup('input[type="number"]', $counter)
  const ownToAball = $quantity.dataset.ownAball
  let count = 0

  const create = () => {
    addEvent()
  }

  const addEvent = () => {
    $plusBtn.addEventListener('click', handlePlusCount)
    $minusBtn.addEventListener('click', handleMinusCount)
    $quantity.addEventListener('keyup', handleKeyboard1)
    $quantity.addEventListener('keydown', handleKeyboard2)
  }

  const handlePlusCount = () => {
    if (!validation()) {
      return
    }

    count = count + 1
    $quantity.value = count
  }

  const handleMinusCount = () => {
    if (count <= 0) {
      return
    }

    count = count - 1
    $quantity.value = count
  }

  const handleKeyboard1 = (e) => {
    if (count > ownToAball) {
      count = Number(ownToAball)
      $quantity.value = count
      $quantity.style.color = "red"
    } else {
      count = Number(e.target.value)
      $quantity.value = count
      $quantity.style.color = "#333"
    }

    if (!validation()) {
      count = Number(ownToAball)
      return
    }
  }

  const handleKeyboard2 = (e) => {

    if (e.keyCode === 38) { // 윗 방향키
      handlePlusCount()
    }
    if (e.keyCode === 40) { // 아래 방향키
      e.preventDefault()

      handleMinusCount()
    }
    
    count = Number(e.target.value)
  }

  const validation = () => {
    if (count >= ownToAball) {
      // alert('보유 아몬드볼이 부족합니다.')
      return false
    }
    return true
  }

  create()
}
