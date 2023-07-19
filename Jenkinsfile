pipeline {
  environment {
    dockerappimagename = "arunvarghe/meetup"
    dockerAppImage = ""
    dockernginximagename = "arunvarghe/nginx"
    dockerNginxImage = ""
  }
  agent any
  stages {
    stage('Checkout Source') {
      steps {
        git 'https://github.com/arunvarghe/meetup.git'
      }
    }
    stage('Build image') {
      steps{
            agent {
              docker {
                  image dockerappimagename
                  args '-f ./docker/prod/Dockerfile'
              }
            }
//         script {
//           dockerAppImage = docker.build dockerappimagename
//         }
      }
    }
    stage('Build NGINX image') {
      steps{
        agent {
            docker {
                image dockernginximagename
                args '-f ./docker/prod/nginx/Dockerfile'
            }
        }
//         script {
//           dockerNginxImage = docker.build dockernginximagename
//         }
      }
    }
    stage('Pushing NGINX Image') {
      environment {
               registryCredential = 'dockerhub-credentials'
           }
      steps{
        script {
          docker.withRegistry( 'https://hub.docker.com', registryCredential ) {
            dockerNginxImage.push("latest")
          }
        }
      }
    }
    stage('Pushing App Image') {
      environment {
               registryCredential = 'dockerhub-credentials'
           }
      steps{
        script {
          docker.withRegistry( 'https://hub.docker.com', registryCredential ) {
            dockerAppImage.push("latest")
          }
        }
      }
    }
//     stage('Deploying React.js container to Kubernetes') {
//       steps {
//         script {
//           kubernetesDeploy(configs: "deployment.yaml", "service.yaml")
//         }
//       }
//     }
  }
}