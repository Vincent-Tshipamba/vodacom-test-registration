// Récupérer les traductions depuis la balise meta
const translations = JSON.parse(document.querySelector('meta[name="translations"]')?.getAttribute('content') || '{}');

function app() {
    return {
        step: 1,
        totalSteps: 5,
        isSubmitting: false,
        image: 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAAAAAAAD/4QBCRXhpZgAATU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAAkAAAAMAAAABAAAAAEABAAEAAAABAAAAAAAAAAAAAP/bAEMACwkJBwkJBwkJCQkLCQkJCQkJCwkLCwwLCwsMDRAMEQ4NDgwSGRIlGh0lHRkfHCkpFiU3NTYaKjI+LSkwGTshE//bAEMBBwgICwkLFQsLFSwdGR0sLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLP/AABEIAdoB2gMBIgACEQEDEQH/xAAfAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgv/xAC1EAACAQMDAgQDBQUEBAAAAX0BAgMABBEFEiExQQYTUWEHInEUMoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+fr/xAAfAQADAQEBAQEBAQEBAAAAAAAAAQIDBAUGBwgJCgv/xAC1EQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/APTmZsnmk3N60N1NJTELub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lJQA7c3rSbm9aSigBdzetG4+tJRQAZPrRuPrSUUALub1/lRub1pKSgBdzUbm9aSigBdzetG5vX+VJSUALub1/lUu5qhqXj1oAG6mkpW6mkoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooASiiigAooooAKSiigAooo+lACUZoooAKKKSgAo/rRSUALUlRVJz60AObqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACkoooAKKKKACiikoAKSlooASiiigA+lHpRQaACkoooATmilpPegBP/ANdS5HrUdSfL7UAObqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKSiigAooooAKKKKAEooooASij60UAFFFHpQAUmaKPxoAKSlpPWgA/wAmk/pS/Sk47dqADpUvPvUXrUn4H8qAHt1NJSt1NJQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFISFBJIAHUk4FAC0VTlv4EyEBc+3C/nVSS9uX6MEHonX8zQBrEqvLEAe5A/nUTXVqvWVfwyf5VjFmY5Ykn3JP86SmBrG/tB3c/RTTf7QtvST8hWXRQBqi/te+8f8AAc09by0b/loB/vAiseigDeV43+66t9CDTq5/p04+lTJdXMfSQkej/MP1oA2qKoR6gpwJUK/7Scj8utXEkjkG5GDD2P8AMUgH0UUUAFFFJQAUUUUAFFFJQAtJRRQAUlFFABR2oo+lAB1pKKP60AFFFFACUHjNH/66KAEpaSj/APVQAc0/I9KZUufpQA5uppKVuppKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACimsyopZiAo5JNZlxePLlI8rH0J/ib60AWp72KLKph3/wDHR9TWdLNNMcuxPoOij6Co6KYBRRRQAUUUUAFFFFABRRRQAUUUUAFKruhDIxUjuDikooA0IL/os4/4Gv8AUVfBVgCpBB6Ecg1gVLBcSwH5eUP3lPQ/SgDaoqOKaOZdyH/eB6qfepKQBRRRQAlFFFABSUUUAFFFFABRRSf5NABxR6e1FJQAcUUUnP6UALSf5/GjvRz+FAB06d6KT6UGgA96kyf8mo//ANdP59P1oAlbqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACmu6RqzucKvJNKSACScADJJ7Csi6uDO2BkRqflHr7mgBLi5edu4QH5V/qagoopgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFACUUUUAPjkkiYOhwR+RHoa14J0nTI4YffX0NYtPileJ1dDyOoPQj0NAG7SUyKVJkDr36juD6U+kAUhoooAKKKKACij/JpKACj/PNFFABScUelFACUdqP8mj+dABn9KMjij60d+tACf5FH5Uf59qOOlACfhUn40zmn4oAlbqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKhuJhDEz/xfdQerGgCpfXGT5CHgf6w+/8AdqhQSSSScknJPqTRTAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACkoooAKKKKACiiigCe2nMEnP+rbhx6e9bHoQevT3zXP1p2M+9DE33k5X/AHf/AK1AF2koNFIAoopKAFpKKPSgApPX0pf8mkoAKKTPP1paAE+lFFIT/ntQAelHAoz0oz/hQAd6T155oooAKk2+wqLPt/8AWqTj1P5GgCZuppKVuppKACiiigAooooAKKKKACiiigAooooAKKKKACiiigArJvpd8uwH5Y+P+BHrWnK4jjkc/wAKkj69qwiSSSepJJ+ppgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABSUUUAFFFFABRRSUAFFFFABT4pDFIkg/hPPuO4plFAG8CGAYchgCD7HmlqpYy74dp6xnH4HkVapALSUUUAH+NFFJQAc0f5+tHFJQAUUUepoAP/r0nP/1sUH1ozQAUnOaPwo9OlAAcd6T60tJQAHn+lSZPotR/55qTJ/yKAJm6mkpW6mkoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAKWoPiNE/vtk/RazKt6g2Zgv9xB+Z5qpTAKKKKACiiigAooooAKKKKACiiigAooooAKKKSgAooooAKKKSgBaSiigAooooAKKKSgC3YPtmKdpFI/EcitSsOJiksTejr+Wa3PSgAoo/zzSflSAWkNBo/nQAlH9aPr60envQAf5NJS0noaADNFH+fYUH/61ACUetFJnGaADg//AK6O/NJ6fhRz0PrQAH/CpefVfzqI46ZNS8UATN1NJSt1NJQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAYt0d1xOf9rA/AYqGnzHMsx/6aP/ADplMAooooAKKKKACiiigAooooAKKKKACiikoAKKKKACiikoAWkoo4oAKKKKACiikoAKWkooAOa3UOUjb1VT+lYVbUB/cwHuY1JoAkz+dGTR2pP5UgAn+lFFHNABSfjzS0nFABn2+lFFIfQj6UAB6c0elH+eKT/JoAPU/wD6qOaPUe1HpQAho+tHXp+lJ/8AqoAOPXrT8H0H50z/ADxUmT6n9KALDdTSUrdTSUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAGFL/AK2b/ro/8zTKluBiecf7Z/XmoqYBRRRQAUUUUAFFFFABRRRQAUUUUAJRRRQAUUUUAFJRRQAUUUUAFFFJQAtJRRQAUUUUAFbUH+og/wCua/yrFrbjGI4h6Io/SgB/NJR60H2pAB/Wj0o5ooATPSjj/P8A9ej/APVSelACn/PrSccYo/z/APXpPf8A/VQAo9KSg9OfX+VHIoAOo7/1pp/P0+lO/Wm8/wD6qAD07dfxo4/Wj9fekyOp/wAigBc9fqKk/Koj39sVLlvf9KALDdTSUrdTSUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAGRfLtuGP95Vb9MVWrQ1FP9TJ9UP8xWfTAKKKKACiiigAooooAKKKKACkoooAKKKKACkpaSgAooooAKKKKACkpaSgAooo5oAKKKSgByjcyL6sAPxrcHHHoMYrJs033Ef+zlz+HStf1xQAn+eKPSj/AD9aPxxSAQ8UUUnrzQAtJn6UZP8An2o5/wA+9ACHt+dHPt3/AP1Uen8qM/rQAZ/wpP8APt60f55o5/rmgA9+1J680fyo7mgBD+H0o6Z4o9/T60UAJz05p/Pv+dM/PnGKk59BQBabqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAguo/MgkUdQNy/Veaxq6CsS5i8qZ1/hJ3L9DTAiooooAKKKKACiiigApKWkoAKKKKACiikoAKKKKACiiigApKWkoAKKKKACiikoAKKKACSoHUkAY96ANDT0wskh/iIUfQcmr3/AOumRRiKNIx/CBn3PenfmaQC+lFJzzQe/wCtAB/k0nX8fSlJpBgcfj+FABRwfw6Un+TRnt+dAB9KT1xR24+uaKAA/wD6/ek6c0fnzQeP55oAPekOf896OOvPTrR+VABwTgen60hwADRS/T8KAEPJ+vTNSc+v8qj5/wAfwqTP0/OgC03U0lK3U0lABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAVUvofMj3qPnjyfqverdFAHP0VYuoDDIcD92+Snt6iq9MAooooAKKKSgAooooAKKKSgAooooAKKKPagAoopKAFpKKKACiiigApKKKACrljFucyt0ThfdqqojSOqJ1Y4+nqa2Y0WNFReijH196AHUpopO34UgD/J5pP1o/w/Wj+tAAcfnzR/hRz9fSk4/wA/yFAB/k0Z46/Wjpn+tJ+NAAT3P6daT/PtS+tJQAd/0o5pOuOaO340AH+Tn1pAf8il9c+lJQAdPWjn/D2oP4e9Hp9PxoATPNSc+g/Sou3SpMD0NAFxuppKVuppKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAjmiSZGRu/IPofWsWSN4nZHGCP19xW9Ve5t1nXsJF+639DQBj0UrKyMysCGBwQabTAKKKKACiiigAopKKACiiigAopKKACiiigAoopKACiiigAzR1xjJNFaNpa7MSyj5uqKf4c9z70ASWlv5K7m/1jdf9kelWT3o/E/Wk/pSAPr6/wA6P50cGk6ZoAP0/Gj/APXRQf8AOKAEx9Pzo59f/r0HH5f1pP6UALx1FJ6cjPOfx7Ufp/jRx6/0oATnijpx+VGc/SkOefT8qAD+p9aD+uaOnNJj88/hQAuaT+lHrzSe/Hv3oAWkyP8APFGeg7d8Un/6qAD8sfrTvl9f1FN6YH6U/j0P5UAXW6mkpW6mkoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAguLZJ154cD5W/oayJIpImKOMHt6EeoNbtMkijlUq6gjt6g+oNAGFRVqezliyyZdOvH3h9RVWmAUlLSUAFFFFABRRRQAUlLSUAFFFFABRRSUAH+RQASQACWPAAHJNSw280x+VcL3Y9K04beKAZHL92P8qAIba0EeHlwXHReoX/AOvVz/Cj0opAJz+dH+FH5/Wk9f8AOKAD9P1o9f60c8Z70Z+lACUfnRRxx+vtQAnr/Wg5/wA9qP8AHvRxj86AE9M96Mn8aOOlJ/8Aq9aAD1/TPWk649sUvfr/AIUnH9KADP6Uf40H/wDX60c/l1oAOvpR/h+FJke/40nPHtn60AGee31NJ6+/tS8dun9fxpOOmPcUAL/hUmR/tfrUJ7/zNSZb1P50AXm6mkpW6mkoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigApKKKACiiigAqvNaQS5ONr/3k/qKsUlAGTLZXEedo3qO69fxFViCDgggjseDW/THjikGHRW+o5/OmBhUVqPYW7fdLp9DkfkahbTn/AIJQf94Y/lQBQoq2bC5GeYz9G/8ArUn2G69F/wC+hQBVoq0LG6PUIPq3+FPGnyn70iD6ZNAFKk/nWmunwjG93b8lFWEggj+5GoPTJGT+ZoAyo7a4kxtQhfVuBV2KxiTBkO8+nRfyq37Ht0ooAOAMDoPQYx9KKOn6UnFIAoo/z+dHagA4pMf5NFHagA+h59KTtR36fjRkc+tAB60n8/8APpSikJFACc+/09qPp75o/wA+oo4zQAZ6+vv/ACpOOPz/ABo6ZyaQ9vb0oAM9vzo/CjPtR2/oaAA496ODx7c0h9+9HJx70AJ3+lHHTP8A9ej8MUnHFAB3o54AoPP50h9fc8UAH+NScev+fzqPp/SpMH/P/wCugC83U0lK3U0lABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUlLSUAFFNeSOMbnYKPfv9BVKXUByIUz/tP/QUAX/X0qB7q2jyC4J9E5P6cVlSTzy/fckenQfkKjpgaJ1FMjETbe5JGfyqzHPBN9xxn0PDfkaxKP8AIoA3/wDPNFY8d3cx4G/cPR+f1q0mop/y0jI91Of0NIC9RUC3dq3/AC0A9mBFSh425DKfoRQA6ko560c+9ABSetLzTSyrncyj6kD+dAC9sUVC1zbLnMi/hz/KoGv4QPkVmPv8ooAuU15I4wS7Ko9zyfwrMkvrh+m1B/s8n8zVYlmOWYknuTk/rTA0X1CINhEZl7nO3P0FPS9tn6sUP+0OD26isqigDdBBGVIOeRtIP8qM9P8A9dYaO8ZJRmU/7JIq1HfyLxIoceo4b/CgDSIpOc1HFPDL9x8nH3Tww/CpM89KQBn/AOtQaT3/ADo/+vQAetJxijPWjigA6fypOOKO3PP1oPTr1zxQAf070np/n9aOaXuaAE4/+tR9Ov8AKg5PNJ+npQAHr/nmk4wc/wD6qMZ/z+NHH6fjQAentR/n2NJ+P/66P69qAD1H696THI+lH40hP+fagBeff2471Jg+pqI+nPT6VJuj9/zNAF9uppKVuppKACiiigAooooAKKKKACiiigAooooAKKKKACkpaimnigXLnk/dUdTQBISqgkkADqTwKoT34GVgGT/fbp+AqpPcSzn5jheyjoKhpgOd3clnYs3qabRSUALSUUUAFFFFABSUtJQAUf59KKKAFDOOAzD8TS+ZL/z0f/vo02koAcXfuzfmTTevX9aKSgBaKPak9KACg0UUAFJRn/69H/1qAA0UH0pKAAZByOCPTircN9ImFly6+v8AEKqHJzRQBtJIki7oyGH6j6in5/8Ar1iJJJG25GII/I/hWjb3SS4DfLJ6HofcUgLPpSZ/z9aX1/XNJ6+npQAcY/Sj29vyo65/SjnP+eKAG/y/WjrS/wCfzo/+tQAn+FJ3x3o6f56UUAJyM8cUUuP8OvakNAB/+qk70ev50maAF5603PtS55Ppn1oPqfWgBOOn40/n0P6VHk8D396mx9aAL7dTSUrdTSUAFFFFABRRRQAUUUUAFFFFABRRRQAUUVXubhYF4wZG+4P6mgAublYBgYMh+6vp7msh3eRi7klj1J/kKGZnYsxJYnJJptMAooooASiiigAo9KKKACiiigBKKKKACiiigApKWkoAKSlooAKTpRRQAUlLSUAFHeik4oAOaKP5Uf8A1qACkooOaACjODkH6e1Ic0UAaFtdlsRyn5sYVvX0Bq7nH096wsjmtC1ut+IZD83ARj3HoaALnXpQCcUfyo5+n+NIBOmaQ85pc89PxpPc8Dt/jQAh7evb8KU+tGevToTSenp3oAD9f/rUe3NJxkf5zR+PpigA57DnFJij6+lB9fWgAJFNPt/9elOfr/8AXpOP6e1AC+n+f1p2D/kmmf0/lUv4f5/KgDQbqaSlbqaSgAooooAKKKKACiiigAooooAKKKT1z2oAjmlSFGdu3AH94+lY0kjyOzuclj+XsKlupzNIcH92nCD196r0wCiiigAopKKACiiigAooooAKSiigAooooAKKKSgAo/z+NFFACcUUUUAFFFJQAUZoozQAlH50c0cUAFFFIfp/9agAo4oooASiiigBPTAoyfp3H/1qP8/nRQBqWtwJV2Mf3i9f9oetT8n61io7RsrqeVPHv7VsRyLIodeh5we3saAHd+Pxo9/84pOOv6mjn8+lIA9/zNJ69aX+VJ6e3WgA6elJye1LwfWkoAMdf0pD29s80uTjGfzpM57UAH8vz/Sk+oo/zn/61J0/GgBe4x6fp9Kkz7fpUf8An8aftP8AkigDSbqaSlbqaSgAooooAKKKKACiiigAooooAKpX0+xBEp+aTr7L/wDXq4SACTwACT9BWHNIZZHkPc8D0UdBQBHRRRTAKSiigAooooAKKKKACkoooAKKKKACkpaSgAoozRQAUUnPNFAB+dFFFABxSc0UUAJn9KKKOlABR/Wj/P1pOKACijmkoAKKKKAE/OjFFHGcUAHr+VHvRxSH2oAP8irVnNsfyz91zgZ7NVWjv+ORz0oA3OvUe4pPzqKGQSxK38XRvqOKk/8A1c+9IA9O3+e9HXjPP6UmeaD6CgAJ6Y9eaD0/mc0f5/Cm/wCf/r0AL+FJ/P8AzxR/niloAT/PsPaj+XbP+NHXP6UnX/69AB/Xr/OpMH3pnHv2qTn1P50AaLdTSUrdTSUAFFFFABRRRQAUUUUAFJRRQBUv5dkQQfekOP8AgI5NZVWb2TfOw7RgIPr3qtTAKKKSgAooooAKKKKACiikoAKKKKACiikoAWkoooAKSiloAT/PFFFFACf4UUdaM0AHY0nPY0UUAFFFJxxigAo/Gj+tFABSZoooAPcelFJ/+ujigA/yaKP88UGgBKPxo96KAEo7/jR3o70AW7GTDmPPDjI/3hWgTWKrbGVx/CQfy7VsghgpHQgE/jQAdf0zQf8AH86D+ntScc+nvSAPrnmj9P8A69JnpQM8fXJ7UAH+foaT29sClPXjHvSf4d6ADPtRkdPxpe3Xt9KT06ewoAOKlwPX9Ki44H4c80/H+cUAabdTSUrdTSUAFFFFABRRRQAUlLSUAFNdgiO56Kpb8hTqrXzbbdx3cqv9aAMgkkknqSSfx5oopKYC0lFFABRRRQAUlFFABRRRQAUUfhRQAUlHJooAPSkpe1JQAp/CkoNFABSUv1pKADpR60UlABx+dFFH6igBKWjmkoAKSlzmkoAM/wCelHpSUc8+9AB+NH+FFBoAM8dKb29+tLnvR/P1oAPWk/OjvRzxQAUUUnH60AHr6Vp2jhoQCTlMr/Wsw1csW5lT1Ab8uKAL3H4dKKP/ANXSjpn260gE7+vejijB/L9KTjII/wAmgBfek+n4fWl5GaD7flQAh9c59MUUcD+VH+cCgA7HH59qlyfb8jUX0HfvzzT+f7woA026mkpW6mkoAKKKKACiikoAKKKKACqGotxCnqWY/hxV+svUT+9Qekf8yaAKdJRRTAKKKKACkpaKAEooooAKKKKACkoooAKOwopPWgA/yKOKKKACkoo9f60AFJS5P+FJ6UAFHNFFABSUUUAGetBopPqaAD+fajrSZoPNAAf84oo9aOcf56UAHce1JzQeM0fSgA9aP85pP8KKAD0o49KKKAEzSelLmkzQAtTWhxOvuGX9M1BT4TtlhP8Atr+pxQBr/nxRzjJ/Gl56elJzxk0gE9Mk0vTuOf1o/wAf880fLQAnXp0/w9KPx9qP8k0f1zQAfjwKPbtzQPp/9ek49eOc0AGfY5Gafg+tMz7egp+1ff8AMUwNRuppKVuppKQBRRSUAFFFFABRRSUALWTf/wCv/wCALWrWVf8A+v8A+ALTAqUUUUAFFFJQAUUUUAHeiiigApKKPxoAPrRRRQAUlFHFAB/+rmg0UlAAaM0dDSfTpQAGiiigA4pKWkFAAaOaDSdqAD0ozR3pKACiiigA9Pb1pPalNJQAUZ+lJRQAGiij/wCv7UABpPWgnv0ooAPxpKKOmRQAdv8AGlj/ANZH/vr/ADpvH9adH/rI/wDfX+dAG0SMnpSY9KM/oaDn8/TikAeuPoaTH55OaOO1HPv/AI0AJ07Dpz6Gl9Pf+tJ0zx1/l1pc8fTpQAn+B5o9Onf15o5wT24zSHpwPwFMA44qTLepph/w+lPw3oaANRuppKVuppKQBSUUUAFFFFABSUUUAFZV/wD8fH/AFrVrJv8A/X/8AWmBVpKWkoAWkoooAKKKKACiikoAKKKDQAUlHtRQAUUUlAAaKPxpKAA0dOlFFABR/Sk5zR/KgBaSiigApO9FH+fxoAP8aPSk6+1J+NAC9x/n86M/5FH50lABRRSUALSUe/p60UAH86TP5UUmaAD0xRR/n6Uf5NAB70UUn/66ADinR/6yP/fU/rTeP8M0sf34+f41/nQBtZ/w/wDrc0nXsPwo/wAg0HvmkAen40Z70n6Z6fj2oIH59aAF70nP4Uf4YoPtxn9KYCc8eoxilznPWj+dJQAdR04NSZPoPzqOpMf5xSA1G6mm05upptABRRRQAUlLSUAFFFFACVlX/wDr/wDgC1q1lX/+v/4AtMCpRRRQAUUUUAFFFJQAUUUUAFJS0lABSUvpSUALSUUE+1ACUUfrRQAetJS0lAC5pP1oooASij2o9fc0AFH0pPT/ADmigAz9cUetHf8ADtSGgAycmjp/hR/+uj60AJR3oo+negAo6UnvRntQAGk9aX86SgAP40nFL+PekoAPX9KKPWk/yaAFpY/vx/768/jSUsePMj9d6/qaANk55+tH8v5UYoHT3HOD70gD/HvSf5/+tR6j19aOP8DTAOMd6Dx0+n/1qP8AI/nQe/tQAdO/5dqSl7Hpn3pPXikAemPp3qbI9aiHWpcD1NAGi3U0lS+n0H8qKAIqKk7UUARUVJQO9AEX+eKKlPb6UnYUAR1lX/8Ar+f7i1telZF//rx/uL/WmBRoqT/61JQAyipP/r0nc/57UAMpKkPf8KO5oAjop56Cg/0oAjop9Hp+FADKSnnrRQAyk61Ieg/Gjt+NAEdH+RUh6fjSDtQAz+dJ0qQ9/wDPakPSgBhpKlPT/PpSHvQBHzSf4mn+v4UGgBnej/PNSdjSdj9BQBH/AIUU80H7v5UAMpDUn9360Dv/AJ70AR/l0o9aef6UD/GgCPij+dSDr+dIe9AEdIal7fjTfX6UAMoz+dOPT8aWgBn+NJUvp+NN/wABQAzmnJ9+P/eX+dKO9SR/6yH/AHx/MUAanH+fekzUnYfSl9f8+lICLj+lH/6/6VKf4P8Ad/wpq/dpgM/Cgc9e2akPf/dpO/4D+YpAM6//AF+v5UZPH+cVJ3/E0rd/+BUAQ89fQcj2qXn1/nR3j+lNPVvqaAP/2Q==',

        formData: {
            // Étape 1: Informations personnelles
            photo: null,
            first_name: '',
            last_name: '',
            phone_number: '',
            gender: 'male',
            date_of_birth: '',
            age: 0,
            vulnerability_type: 'none',

            // Étape 2: Adresse
            current_city: '',
            diploma_city: '',
            full_address: '',

            // Étape 3: Informations scolaires
            school_name: '',
            option_studied: '',
            other_study_option: '',
            national_exam_code: '',
            percentage: '',

            // Étape 4: Pièces jointes
            id_document: null,
            diploma: null,
            recommendation: null,

            // Étape 5: Ambitions personnelles
            intended_field: '',
            other_university_field: '',
            intended_field_motivation: '',
            career_goals: '',
            additional_infos: ''
        },
        errors: {},

        minScore: 70,
        maxScore: 100,
        MAX_FILE_SIZE: 5 * 1024 * 1024,
        allowedFileTypes: ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],

        // Calcul de l'âge à partir de la date de naissance
        calculateAge() {
            if (this.formData.date_of_birth) {
                const birthDate = new Date(this.formData.date_of_birth);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                this.formData.age = age;

                const field = document.getElementById('date_of_birth');
                if (!field) return;

                if (age < 16 || age > 20) {
                    this.errors.date_of_birth = field.dataset.errorAge;
                } else if (this.errors.date_of_birth === field.dataset.errorAge) {
                    delete this.errors.date_of_birth;
                }

                setTimeout(() => {
                    this.formData = { ...this.formData };
                }, 0);
            }
        },

        nextStep() {
            if (this.isSubmitting) return;
            // existing logic (if any) is handled in the template via @click
            if (this.step < this.totalSteps) {
                if (this.validateStep(this.step)) {
                    this.step++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    const firstError = Object.keys(this.errors)[0];
                    if (firstError) {
                        const el = document.getElementById(firstError);
                        el?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        el?.focus?.();
                    }
                }
            }
        },

        validateFields(fields = []) {
            let isValid = true;
            fields.forEach((field) => {
                const fieldElement = document.getElementById(field.id);

                if (!fieldElement) {
                    console.error(`Élément non trouvé pour l'ID: ${field.id}`);
                    return;
                }

                // Appliquer une valeur par défaut AVANT la validation required
                if (field.useADefaultValue) {
                    if (!this.formData[field.name] && this.formData[field.defaultValueField]) {
                        this.formData[field.name] = this.formData[field.defaultValueField];
                        // Nettoyer une éventuelle erreur existante liée au champ
                        if (this.errors[field.name]) {
                            delete this.errors[field.name];
                        }
                        // Répercuter la valeur dans le champ pour cohérence UI
                        if (fieldElement && typeof fieldElement.value !== 'undefined') {
                            fieldElement.value = this.formData[field.name];
                        }
                    }
                }

                if (field.required && !this.formData[field.name]) {
                    this.errors[field.name] = fieldElement.dataset.errorRequired;
                    isValid = false;
                    return;
                }

                if (field.validateFile) {
                    const file = this.formData[field.name];
                    if (file && file.size > this.MAX_FILE_SIZE) {
                        this.errors[field.name] = fieldElement.dataset.errorSize;
                        isValid = false;
                        return;
                    } else if (file && !this.allowedFileTypes.includes(file.type)) {
                        this.errors[field.name] = fieldElement.dataset.errorType;
                        isValid = false;
                        return;
                    }
                }

                if (field.validatePhoneNumber) {
                    if (!/^[0-9]{9,15}$/.test(this.formData.phone_number)) {
                        this.errors[field.name] = fieldElement.dataset.errorPhone;
                        isValid = false;
                        return;
                    }
                }

                if (field.validateAge) {
                    if (this.formData[field.name] < 16 || this.formData[field.name] > 20) {
                        this.errors[field.name] = fieldElement.dataset.errorAge;
                        isValid = false;
                        return;
                    }
                }

                // (déplacé plus haut, avant required)

                if (field.hasPersonalizedOption) {
                    const isOtherOptionSelected = this.formData[field.name] === field.personalizedOptionValue;
                    const otherField = this.formData[field.personalizedOptionField];

                    if (isOtherOptionSelected && !otherField) {
                        // Cas 1: "Autre" est sélectionné mais le champ est vide
                        const personalizedOptionFieldElement = document.getElementById(field.personalizedOptionField);
                        this.errors[field.personalizedOptionField] = personalizedOptionFieldElement.dataset.errorRequired;
                        isValid = false;
                        return;
                    } else if (isOtherOptionSelected && otherField) {
                        // Cas 2: "Autre" est sélectionné et le champ est rempli
                        delete this.errors[field.personalizedOptionField];
                    } else if (!isOtherOptionSelected && otherField) {
                        // Cas 3: Une autre option est sélectionnée mais le champ personnalisé a une valeur
                        this.formData[field.personalizedOptionField] = '';
                    }
                }

                if (field.validateCode) {
                    if (!/^\d{14}$/.test(this.formData[field.name])) {
                        this.errors[field.name] = fieldElement.dataset.errorPattern;
                        isValid = false;
                        return;
                    }
                }

                if (field.validateScore) {
                    if (this.formData[field.name] < this.minScore || this.formData[field.name] > this.maxScore) {
                        this.errors[field.name] = fieldElement.dataset.errorPercentage;
                        isValid = false;
                        return;
                    }
                }
            });

            return isValid;
        },

        // Vérification des champs obligatoires
        validateStep(step) {
            this.errors = {};
            let isValid = true;

            // Validation de l'étape 1
            if (step === 1) {
                const stepOnefieldsToValidate = [
                    {
                        'name': 'photo',
                        'validateFile': true,
                        'id': 'fileInput',
                    },
                    {
                        'name': 'first_name',
                        'id': 'first_name',
                        'required': true,
                    },
                    {
                        'name': 'last_name',
                        'id': 'last_name',
                        'required': true,
                    },
                    {
                        'name': 'phone_number',
                        'id': 'phone_number',
                        'validatePhoneNumber': true,
                        'required': true,
                    },
                    {
                        'name': 'date_of_birth',
                        'id': 'date_of_birth',
                        'validateAge': true,
                    },
                    {
                        'name': 'vulnerability_type',
                        'id': 'vulnerability_type',
                        'required': true
                    }
                ];

                isValid = this.validateFields(stepOnefieldsToValidate);
                console.log("isValid 1: ", isValid);
            } else if (step === 2) { // Validation de l'etape 2
                const stepTwoFieldsToValidate = [
                    {
                        'name': 'current_city',
                        'id': 'current_city',
                        'required': true,
                    },
                    {
                        'name': 'diploma_city',
                        'id': 'diploma_city',
                        'useADefaultValue': true,
                        'defaultValueField': 'current_city',
                        'required': true,
                    },
                    {
                        'name': 'full_address',
                        'id': 'full_address',
                        'required': true,
                    },
                ];

                isValid = this.validateFields(stepTwoFieldsToValidate);
                console.log("isValid 2: ", isValid);
            } else if (step === 3) {
                const stepThreeFieldsToValidate = [
                    {
                        'name': 'school_name',
                        'id': 'school_name',
                        'required': true,
                    },
                    {
                        'name': 'option_studied',
                        'id': 'option_studied',
                        'hasPersonalizedOption': true,
                        'personalizedOptionValue': 'other',
                        'personalizedOptionField': 'other_study_option',
                        'required': true,
                    },
                    {
                        'name': 'percentage',
                        'id': 'percentage',
                        'validateScore': true,
                        'required': true,
                    },
                    {
                        'name': 'national_exam_code',
                        'id': 'national_exam_code',
                        'validateCode': true,
                        'required': true,
                    }
                ];

                isValid = this.validateFields(stepThreeFieldsToValidate);
                console.log("isValid 3: ", isValid);
            } else if (step === 4) {
                const stepFourFieldsToValidate = [
                    {
                        'name': 'id_document',
                        'id': 'id_document',
                        'validateFile': true,
                        'required': true,
                    },
                    {
                        'name': 'diploma',
                        'id': 'diploma',
                        'validateFile': true,
                        'required': true,
                    },
                    {
                        'name': 'recommendation',
                        'id': 'recommendation',
                        'validateFile': true,
                        'required': false,
                    }
                ]
                isValid = this.validateFields(stepFourFieldsToValidate);
                console.log("isValid 4: ", isValid);
            } else if (step === 5) {
                const stepFiveFieldsToValidate = [
                    {
                        'name': 'intended_field',
                        'id': 'intended_field',
                        'hasPersonalizedOption': true,
                        'personalizedOptionValue': 'other',
                        'personalizedOptionField': 'other_university_field',
                        'required': true,
                    },
                    {
                        'name': 'intended_field_motivation',
                        'id': 'intended_field_motivation',
                        'required': true,
                    },
                    {
                        'name': 'career_goals',
                        'id': 'career_goals',
                        'required': true,
                    }
                ];

                isValid = this.validateFields(stepFiveFieldsToValidate);
                console.log("isValid 5: ", isValid);
            }

            return isValid;
        },

        // Navigation entre les étapes
        nextStep() {
            console.log('Validation de l\'étape', this.step);
            if (this.validateStep(this.step)) {
                console.log('Validation réussie, passage à l\'étape suivante');
                if (this.step < this.totalSteps) {
                    this.step++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } else {
                // Faire défiler jusqu'au premier champ en erreur
                const firstError = Object.keys(this.errors)[0];
                console.log('Première erreur:', firstError);
                if (firstError) {
                    const errorElement = document.getElementById(firstError);
                    if (errorElement) {
                        errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        errorElement.focus();
                    }
                }
            }
        },

        prevStep() {
            if (this.isSubmitting) return;
            if (this.step > 1) {
                this.step--;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },

        // Soumission du formulaire
        submitForm() {
            if (this.isSubmitting) {
                return;
            }

            this.isSubmitting = true;

            // Valider avant d'envoyer; si invalide, déverrouiller
            if (!this.validateStep(this.step)) {
                this.isSubmitting = false;
                return;
            }

            if (this.validateStep(this.step)) {
                console.log('Formulaire soumis avec succès:', this.formData);

                const form = document.getElementById('registrationForm');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(async (response) => {
                        // Succès HTTP
                        if (response.ok) {
                            const data = await response.json();
                            console.log('data : ', data);
                            if (data && data.success) {
                                this.step = 'complete';
                                if (data.redirect) {
                                    window.location.href = data.redirect;
                                }
                            } else {
                                // Réponse OK mais pas de success flag
                                console.warn('Réponse OK sans success:true');
                            }
                            return;
                        }

                        // Erreurs de validation Laravel (422)
                        if (response.status === 422) {
                            const payload = await response.json().catch(() => ({}));
                            const errors = payload.errors || {};
                            this.errors = {};

                            // Mapping champs serveur -> IDs/front
                            const fieldIdMap = {
                                firstname: 'first_name',
                                lastname: 'last_name',
                                phone: 'phone_number',
                                gender: 'gender',
                                birthdate: 'date_of_birth',
                                identification_type: 'vulnerability_type',

                                current_city: 'current_city',
                                diploma_city: 'diploma_city',
                                full_address: 'full_address',

                                school_name: 'school_name',
                                study_option: 'option_studied',
                                other_study_option: 'other_study_option',
                                diploma_score: 'percentage',
                                student_code: 'national_exam_code',

                                id_document: 'id_document',
                                diploma: 'diploma',
                                recommendation: 'recommendation',

                                university_field: 'intended_field',
                                other_university_field: 'other_university_field',
                                passion: 'intended_field_motivation',
                                career_goals: 'career_goals',
                                additional_info: 'additional_infos'
                            };

                            // Mapping champ -> étape pour focus
                            const fieldStepMap = {
                                first_name: 1, last_name: 1, phone_number: 1, gender: 1, date_of_birth: 1, vulnerability_type: 1,
                                current_city: 2, diploma_city: 2, full_address: 2,
                                school_name: 3, option_studied: 3, other_study_option: 3, percentage: 3, national_exam_code: 3,
                                id_document: 4, diploma: 4, recommendation: 4,
                                intended_field: 5, other_university_field: 5, intended_field_motivation: 5, career_goals: 5, additional_infos: 5
                            };

                            let firstErrorFieldId = null;
                            Object.keys(errors).forEach((serverField) => {
                                const fieldId = fieldIdMap[serverField] || serverField;
                                const messages = errors[serverField];
                                if (Array.isArray(messages) && messages.length) {
                                    // Enregistrer pour rendu inline
                                    this.errors[fieldId] = messages[0];
                                    if (!firstErrorFieldId) firstErrorFieldId = fieldId;
                                }
                            });

                            // Gérer un message d'erreur général non lié à un champ
                            if (errors.general) {
                                const generalMsg = Array.isArray(errors.general) && errors.general.length ? errors.general[0] : errors.general;
                                this.errors.general = generalMsg;
                                this.$nextTick?.(() => {
                                    const globalEl = document.getElementById('form-global-error');
                                    if (globalEl) {
                                        globalEl.textContent = generalMsg;
                                        globalEl.classList.remove('hidden');
                                        globalEl.classList.add('block');
                                        // Accessibilité: amener le conteneur en vue et lui donner le focus
                                        globalEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        if (!globalEl.hasAttribute('tabindex')) {
                                            globalEl.setAttribute('tabindex', '-1');
                                        }
                                        globalEl.focus?.();
                                    } else if (generalMsg) {
                                        // Fallback si aucun conteneur dédié n'est présent
                                        alert(generalMsg);
                                    }
                                });
                            }

                            // Aller à l'étape contenant la première erreur
                            if (firstErrorFieldId && fieldStepMap[firstErrorFieldId]) {
                                this.step = fieldStepMap[firstErrorFieldId];
                            }

                            // Scroll/Focus sur le premier champ en erreur
                            this.$nextTick?.(() => {
                                const el = document.getElementById(firstErrorFieldId);
                                if (el) {
                                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    el.focus?.();
                                }
                            });
                            return;
                        }

                        // Autres erreurs
                        console.error('Erreur lors de la soumission du formulaire:', response.status, response.statusText);
                    })
                    .catch(error => {
                        console.error('Erreur réseau lors de la soumission du formulaire:', error);
                    })
                    .finally(() => {
                        this.isSubmitting = false;
                    });
            }
        },

        // Obtention du titre de l'étape
        getStepTitle(step) {
            const titles = {
                1: '{{ __("registration.step_1_title") }}',
                2: '{{ __("registration.step_2_title") }}',
                3: '{{ __("registration.step_3_title") }}',
                4: '{{ __("registration.step_4_title") }}',
                5: '{{ __("registration.step_5_title") }}'
            };
            return titles[step] || '';
        }
    };
}
