export async function remoteRequest(url, args = {}) {
    // requestInProgress.set(true);
    let data = [];
      
    if (args.method === undefined) {
      args.method = 'GET';
    }
    if (args.headers === undefined) {
        args.headers = {};
    }
  
    if(args.headers["Content-Type"] === undefined) {
      args.headers["Content-Type"] = "application/json";
    }
  
    const response = await fetch(url, args);
  
    if (response.ok) {
      data.json = await response.json();
      data.url = url;
    }
  
    // requestInProgress.set(false);
  
    return data;
  }
  