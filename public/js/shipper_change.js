

const selectInputs = document.getElementsByClassName('shipChange');

for (let i = 0; i < selectInputs.length; i++) {
    selectInputs[i].onchange = (event) => {
        var inputText = event.target.value;
        console.log(`select option ${i+1}`, inputText);
        const shipDetailsDivs = document.getElementsByClassName('ship_details');
        const issueDetailsDivs = document.getElementsByClassName('issue_details');
        
        switch (inputText) {
            case 'ship':
                if (shipDetailsDivs[i].style.visibility === 'hidden') {
                    shipDetailsDivs[i].style.visibility = 'visible';
                    issueDetailsDivs[i].style.visibility = 'hidden';
                } else {
                    shipDetailsDivs[i].style.visibility = 'hidden';
                }
                break;
            case 'issue':
                if (issueDetailsDivs[i].style.visibility === 'hidden') {
                    issueDetailsDivs[i].style.visibility = 'visible';
                    shipDetailsDivs[i].style.visibility = 'hidden';
                } else {
                    issueDetailsDivs[i].style.visibility = 'hidden';
                }
                break;
            default:
                break;
        }
    }
  }
  